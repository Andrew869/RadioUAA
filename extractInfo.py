import requests
from bs4 import BeautifulSoup
import time

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
                response_enlace = requests.get(enlace)
                if response_enlace.status_code == 200:
                    soup_link = BeautifulSoup(response_enlace.content, 'html.parser')
                    
                    nombre_programa = soup_link.find('h1', class_='entry-title').text.strip()
                    programa['nombre'] = nombre_programa
                    print(f"Nombre del programa: {nombre_programa}")

                    imagen = soup_link.find('img', class_='show-image')
                    url_img = imagen['src'] if imagen else None
                    programa['url_img'] = url_img

                    descripcion_div = soup_link.find('div', class_='show-desc-content')
                    descripcion = descripcion_div.find('p').text.strip() if descripcion_div else None
                    programa['descripcion'] = descripcion

                    presentador_div = soup_link.find('div', class_='show-djs show-hosts')
                    if presentador_div:
                        programa_presentadores = []
                        for presentador in presentador_div.find_all('a'):
                            presentador = presentador.text.strip()
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
                            horario = {}
                            dia_texto = dia.find('b').text.strip()
                            horario['dia'] = dia_texto
                            horario_info = dia.find_next_sibling('td')
                            if horario_info:
                                start_time = horario_info.find('span', class_='rs-start-time').text.strip()
                                horario['hora_inicio'] = start_time
                                end_time = horario_info.find('span', class_='rs-end-time').text.strip()
                                horario['hora_fin'] = end_time
                                es_retransmision = horario_info.find('span', class_='show-encore') is not None
                                horario['es_retransmision'] = 1 if es_retransmision else 0
                                horarios.append(horario)
                    programa['horarios'] = horarios
                    programas.append(programa)
                    success = True  # Salir del bucle si la solicitud fue exitosa

            except (requests.exceptions.ConnectTimeout, requests.exceptions.ReadTimeout, requests.exceptions.RequestException) as e:
                index_try += 1
                print(f"Error: {e}. Intento {index_try} de {max_tries}. Reintentando...")
                time.sleep(5)  # Esperar 5 segundos antes de intentar de nuevo


    dias = {
        "Lun": "Lunes",
        "Mar": "Martes",
        "Mié": "Miércoles",
        "Jue": "Jueves",
        "Vie": "Viernes",
        "Sáb": "Sábado",
        "Dom": "Domingo"
    }
    def transformar_dia(dia_abreviado):
        return dias.get(dia_abreviado, dia_abreviado) 
    
    programaIndex = 1
    with open('inserciones_radio.sql', 'w', encoding='utf-8') as archivo:
        for presentador,id in presentadores.items():
            insert_presentador = f"INSERT INTO presentador (nombre_presentador) VALUES ('{presentador}');"
            archivo.write(insert_presentador + "\n")

        for genero,id in generos.items():
            insert_genero = f"INSERT INTO genero (nombre_genero) VALUES ('{genero}');"
            archivo.write(insert_genero + "\n")

        for programa in programas:
            insert_programa = f"INSERT INTO programa (nombre_programa, url_img, descripcion) VALUES ('{programa['nombre']}', '{programa['url_img']}', '{programa['descripcion']}');"
            archivo.write(insert_programa + "\n")

            if programa.get('horarios'):
                for horario in programa['horarios']:
                    insert_horario = f"INSERT INTO horario (id_programa, dia_semana, hora_inicio, hora_fin, es_retransmision) " \
                                    f"VALUES ({programaIndex}, '{transformar_dia(horario['dia'])}', '{horario['hora_inicio']}', '{horario['hora_fin']}', {1 if horario['es_retransmision'] else 0});"
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
