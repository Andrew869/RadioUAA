import os
import re
import hashlib

def short_hash(data):
    # Function to get the first 6 characters of MD5 hash as a string
    return hashlib.md5(data.encode('utf-8')).hexdigest()[:6]

def replace_hash_in_files():
    # Generate the hash
    hash_project = short_hash(read_folder_content('js'))

    # Regular expression pattern to find the pattern ".js?v=hash_here';"
    js_pattern = re.compile(r'\.js\?v=(.*?);')
    php_pattern = re.compile(r"define\('PROJECT_HASH', '[\da-f]{6}'\);", re.MULTILINE)

    for root, _, files in os.walk('js'):
        for filename in files:
            file_path = os.path.join(root, filename)
            try:
                # Read the file content
                with open(file_path, 'r', encoding='utf-8') as file:
                    content = file.read()
                    # Check if the pattern exists in the content
                    if js_pattern.search(content):
                        # Replace the pattern in the content
                        new_content = js_pattern.sub(f".js?v={hash_project}';", content)
                        # Write the modified content back to the file
                        with open(file_path, 'w', encoding='utf-8') as file_write:
                            file_write.write(new_content)
                            print(f"Updated file: {file_path}")
                    else:
                        print(f"No pattern found in file: {file_path}")

            except Exception as e:
                print(f"Failed to process file {file_path}: {e}")

    # Save the hash as a constant in utilities.php
    utilities_file = 'php/utilities.php'
    try:
        with open(utilities_file, 'r+', encoding='utf-8') as php_file:
            content = php_file.read()
            # Check if the pattern exists in the content
            if php_pattern.search(content):
                # Replace the hash in the pattern
                new_content = php_pattern.sub(f"define('PROJECT_HASH', '{hash_project}');", content)
                # Write the modified content back to the file
                php_file.seek(0)
                php_file.write(new_content)
                php_file.truncate()
                print(f"Updated file: {utilities_file}")
            else:
                print(f"No pattern found in {utilities_file}")

    except Exception as e:
        print(f"Failed to update {utilities_file}: {e}")

def read_folder_content(folder):
    hash_data = ""
    for root, _, files in os.walk(folder):
        for filename in files:
            try:
                with open(os.path.join(root, filename), "rb") as file:
                    content = file.read()
                    hash_data += content.decode('utf-8', errors='ignore')
            except Exception as e:
                print(f"Failed to read file {filename}: {e}")
    
    return hash_data

# Run the function to replace the hash in the files and save as constant in utilities.php
replace_hash_in_files()
