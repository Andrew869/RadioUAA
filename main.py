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
    pattern = re.compile(r'\.js\?v=(.*?);')

    for root, _, files in os.walk('js'):
        for filename in files:
            file_path = os.path.join(root, filename)
            try:
                # Read the file content
                with open(file_path, 'r', encoding='utf-8') as file:
                    content = file.read()
                
                # Find and replace the pattern in the content
                new_content = pattern.sub(f".js?v={hash_project}';", content)

                # Write the modified content back to the file
                with open(file_path, 'w', encoding='utf-8') as file:
                    file.write(new_content)

                print(f"Updated file: {file_path}")

            except Exception as e:
                print(f"Failed to process file {file_path}: {e}")

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

# Run the function to replace the hash in the files
replace_hash_in_files()
