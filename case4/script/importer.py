import os
import time
import mysql.connector

# Tunggu sebentar agar MySQL siap sepenuhnya
time.sleep(10)

# Koneksi ke Database
# Hostname 'mysql1' bisa dipakai karena satu network docker
db = mysql.connector.connect(
    host="mysql1",
    user="root",
    password="mydb6789tyui",
    database="mydb"
)
cursor = db.cursor()
folder_path = "/data"

print("Processor Service Berjalan...")

while True:
    # Cek file di folder shared
    if os.path.exists(folder_path):
        for filename in os.listdir(folder_path):
            if filename.endswith(".txt"):
                filepath = os.path.join(folder_path, filename)
                
                try:
                    with open(filepath, 'r') as f:
                        content = f.read()
                    
                    # Insert ke DB
                    sql = "INSERT INTO jokes (filename, content) VALUES (%s, %s)"
                    cursor.execute(sql, (filename, content))
                    db.commit()
                    print(f"Sukses import: {filename}")
                    
                    # Hapus file agar tidak duplikat
                    os.remove(filepath)
                except Exception as e:
                    print(f"Error: {e}")
    
    time.sleep(5)
