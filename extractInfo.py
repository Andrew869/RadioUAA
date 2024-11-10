import requests # Para hacer solicitudes a una pagina web
from bs4 import BeautifulSoup # Para obtener el contenido de una pagina web
from PIL import Image # Para modificar imagenes
import time # Para dormir el proceso
import re # Para usar regex
import os # Para comprobar si un archivo existe
import shutil # Para copiar archivos

# Número máximo de intentos
MAX_RETRIES = 3
# Tiempo de espera entre reintentos (en segundos)
RETRY_DELAY = 5

def download_image(url, pathImg):
    retries = 0

    while retries < MAX_RETRIES:
        try:
            # Realizar la solicitud
            response = requests.get(url, timeout=10)  # Se puede ajustar el timeout
            if response.status_code == 200:
                with open(pathImg, 'wb') as f:
                    f.write(response.content)
                print(f"descargada con éxito: {url}")
                return True
            else:
                print(f"Error en la descarga: {url}, {response.status_code}")
                return False
        except requests.exceptions.Timeout:
            retries += 1
            print(f"Timeout al intentar descargar: {url}. Reintentando {retries}/{MAX_RETRIES}...")
            time.sleep(RETRY_DELAY)  # Espera antes de volver a intentar
        except requests.exceptions.RequestException as e:
            retries += 1
            print(f"Error de conexión: {e}, {url}. Reintentando {retries}/{MAX_RETRIES}...")
            time.sleep(RETRY_DELAY)  # Espera antes de volver a intentar
    else:
        print(f"Fallo al descargar la imagen después de {MAX_RETRIES} intentos.")
        return False
    
def resize_image_to_webp(input_image_path, output_image_path, target_width):
    try:
        # Abrir la imagen
        img = Image.open(input_image_path)
        original_width, original_height = img.size

        # Verificar si la imagen ya tiene un ancho menor o igual al objetivo
        if original_width <= target_width:
            target_width = original_width
            target_height = original_height
        else:
            # Calcular el nuevo alto manteniendo el aspect ratio original
            target_height = int((original_height / original_width) * target_width)
            

        # Redimensionar la imagen
        resized_img = img.resize((target_width, target_height), Image.LANCZOS)

        # Guardar la imagen redimensionada en formato WEBP
        resized_img.save(output_image_path, 'WEBP')

        print(f"Imagen redimensionada y convertida a WEBP: {output_image_path}")

    except IOError:
        print(f"No se pudo abrir la imagen: {input_image_path}")
    except Exception as e:
        print(f"Error al procesar la imagen: {e}")

# URL base
url_base = 'https://radio.uaa.mx/contenidos/'

# Hacer la solicitud GET a la página principal
response = requests.get(url_base)

# Verificar que la solicitud fue exitosa (código 200)
if response.status_code == 200:
    # Parsear el contenido HTML con BeautifulSoup
    soup = BeautifulSoup(response.content, 'html.parser')

    # Encontrar todos los enlaces <a> que contienen 'https://radio.uaa.mx/show/'
    enlaces = set()  # Usar un conjunto para evitar duplicados
    aElement = soup.find_all('a', href=True)
    for link in aElement:
        href = link['href']
        if href.startswith('https://radio.uaa.mx/show/'):
            enlaces.add(href)
    
    enlaces = sorted(enlaces, key=lambda x: x.split('/')[-2])
    # enlaces = list(enlaces)

    # enlaces = ['https://radio.uaa.mx/show/soy-comunicacion-radio/'
    presentadores = {}
    presentadoresIndex = 1
    generos = {}
    generoIndex = 1
    programas = []
    for enlace in enlaces:
    # for i in range(5):
        # enlace = enlaces[i]
        index_try = 0
        max_tries = 3
        success = False
        programa = {}
        while index_try < max_tries and not success:
            try:
                # Realizar una nueva solicitud GET a cada enlace encontrado
                response_enlace = requests.get(enlace, timeout=10)
                if response_enlace.status_code == 200:
                    soup_link = BeautifulSoup(response_enlace.content, 'html.parser')
                    
                    nombre_programa = soup_link.find('h1', class_='entry-title').text.strip()
                    programa['nombre'] = nombre_programa
                    print(f"Nombre del programa: {nombre_programa}")

                    image = soup_link.find('img', class_='show-image')
                    if not image:
                        image = soup_link.find('img', class_='wp-post-image')

                    url_img = image['src'] if image else None
                    programa['url_img'] = url_img

                    descripcion_div = soup_link.find('div', class_='show-desc-content')
                    descripcion = descripcion_div.find('p').text.strip() if descripcion_div else None
                    programa['descripcion'] = descripcion

                    presentador_div = soup_link.find('div', class_='show-djs show-hosts')
                    if presentador_div:
                        programa_presentadores = []
                        for presentador in presentador_div.find_all('a'):
                            presentador = presentador.text.strip()
                            if presentador != '':
                                if not presentadores.get(presentador):
                                    presentadores[presentador] = presentadoresIndex
                                    presentadoresIndex += 1
                                programa_presentadores.append(presentadores[presentador])
                        programa['presentadores'] = programa_presentadores
                   
                    generos_div = soup_link.find('div', class_='show-genres')
                    # programa_generos = [genero.text.strip() for genero in generos_div.find_all('a')] if generos_div else []
                    if generos_div:
                        programa_generos = []
                        for genero in generos_div.find_all('a'):
                            genero = genero.text.strip()
                            if not generos.get(genero):
                                generos[genero] = generoIndex
                                generoIndex += 1
                            programa_generos.append(generos[genero])
                        programa['generos'] = programa_generos
                    
                    horarios_div = soup_link.find('div', class_='show-times')
                    if horarios_div:
                        horarios = []
                        dias = horarios_div.find_all('td', class_='show-day-time')
                        for dia in dias:
                            # horario = {}
                            dia_texto = dia.find('b').text.strip()
                            # horario['dia'] = dia_texto
                            horario_info = dia.find_next_sibling('td')
                            if horario_info:
                                tiempos = horario_info.find_all('span', class_='show-time')
                                for tiempo in tiempos:
                                    horario = {}
                                    horario['dia'] = dia_texto
                                    start_time = tiempo.find('span', class_='rs-start-time').text.strip()
                                    horario['hora_inicio'] = start_time
                                    end_time = tiempo.find('span', class_='rs-end-time').text.strip()
                                    horario['hora_fin'] = end_time
                                    es_retransmision = tiempo.find('span', class_='show-encore') is not None
                                    horario['es_retransmision'] = 1 if es_retransmision else 0
                                    horarios.append(horario)
                    programa['horarios'] = horarios
                    programas.append(programa)
                    success = True  # Salir del bucle si la solicitud fue exitosa

            except (requests.exceptions.ConnectTimeout, requests.exceptions.ReadTimeout, requests.exceptions.RequestException) as e:
                index_try += 1
                print(f"Error: {e}. Intento {index_try} de {max_tries}. Reintentando...")
                time.sleep(RETRY_DELAY)  # Esperar 5 segundos antes de intentar de nuevo


    dias = {
        "Lun": "1",
        "Mar": "2",
        "Mié": "3",
        "Jue": "4",
        "Vie": "5",
        "Sáb": "6",
        "Dom": "7"
    }
    def transformar_dia(dia_abreviado):
        return dias.get(dia_abreviado, dia_abreviado) 
    
    programaIndex = 1
    with open('inserciones_radio.sql', 'w', encoding='utf-8') as archivo:
        for presentador,id in presentadores.items():
            pathImgProfile =  'resources/uploads/img/presentador_' + str(id) + '[v0].jpg'
            if not os.path.exists(pathImgProfile):
                defaultImgPath = 'resources/img/presentador_default.jpg' 
                shutil.copy(defaultImgPath, pathImgProfile)
            insert_presentador = f"INSERT INTO presentador (nombre_presentador, url_img) VALUES ('{presentador}', '{pathImgProfile}');"
            archivo.write(insert_presentador + "\n")

        for genero,id in generos.items():
            insert_genero = f"INSERT INTO genero (nombre_genero) VALUES ('{genero}');"
            archivo.write(insert_genero + "\n")

        for programa in programas:
            pathImg = 'resources/uploads/img/programa_' + str(programaIndex) + '[v0]'
            imgFlag = False
            alreadyExist = False
            if programa['url_img']:
                if programa['url_img'] != 'https://radio.uaa.mx/wp-content/uploads/2023/06/indiespensables-800x800px-300x300.png':
                    url = re.sub(r'-\d+x\d+', '', programa['url_img'])
                else:
                    url = programa['url_img']

                nombre_archivo, extension = os.path.splitext(url)
                # outputPath = pathImg + extension
                outputPath = pathImg
                lowResWidth = 300
                # lowResPath = pathImg + str(lowResWidth) + ".webp"
                lowResPath = pathImg + '.' + str(lowResWidth)
                alreadyExist = os.path.exists(outputPath)
                if not alreadyExist:
                    imgFlag = download_image(url, outputPath)
                    resize_image_to_webp(outputPath, lowResPath, lowResWidth)

                # if not os.path.exists(pathImg):
                #     response = requests.get(url)
                #     if response.status_code == 200:
                #         with open(pathImg, 'wb') as f:
                #             f.write(response.content)

            if not imgFlag and not alreadyExist:
                defaultImgPath = 'resources/img/programa_default.jpg'
                nombre_archivo, extension = os.path.splitext(defaultImgPath)
                outputPath = pathImg
                lowResWidth = 300
                lowResPath = pathImg + '.' + str(lowResWidth)
                shutil.copy(defaultImgPath, outputPath)
                resize_image_to_webp(outputPath, lowResPath, lowResWidth)
            


            insert_programa = f"INSERT INTO programa (nombre_programa, url_img, descripcion) VALUES ('{programa['nombre']}', '{outputPath}', '{programa['descripcion']}');"
            archivo.write(insert_programa + "\n")

            if programa.get('horarios'):
                for horario in programa['horarios']:
                    insert_horario = f"INSERT INTO horario (id_programa, dia_semana, hora_inicio, hora_fin, es_retransmision) " \
                                    f"VALUES ({programaIndex}, {transformar_dia(horario['dia'])}, '{horario['hora_inicio']}', '{horario['hora_fin']}', {1 if horario['es_retransmision'] else 0});"
                    archivo.write(insert_horario + "\n")
            
            if programa.get('presentadores'):
                for presentador_id in programa['presentadores']:
                    insert_programa_presentador = f"INSERT INTO programa_presentador (id_programa, id_presentador) VALUES ({programaIndex}, {presentador_id});"
                    archivo.write(insert_programa_presentador + "\n")

            if programa.get('generos'):
                for genero_id in programa['generos']:
                    insert_programa_genero = f"INSERT INTO programa_genero (id_programa, id_genero) VALUES ({programaIndex}, {genero_id});"
                    archivo.write(insert_programa_genero + "\n")

            programaIndex += 1
else:
    print(f"Error al acceder a la página: {response.status_code}")

# DROP TABLE programa_presentador;
# DROP TABLE programa_genero;
# DROP TABLE genero;
# DROP TABLE presentador;
# DROP TABLE horario;
# DROP TABLE programa;
# DROP TABLE user;
