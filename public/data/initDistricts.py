import pandas as pd
import mysql.connector

df21 = pd.read_json("d21.json")

db = mysql.connector.connect(host="localhost",database="okl",raw=True,user="oklab",passwd="oklab123")
curs = db.cursor()

# delete all
curs.execute("delete from districts")
db.commit()

sql = "INSERT INTO districts (name, size) VALUES (%s, %s)"

curs = db.cursor()
for t in df21.itertuples():
    print(t)
    curs.execute(sql,(t.Stadtteil,t.Wohnberechtigte))

db.commit()

