import requests
import mysql.connector

path = "http://api.nbp.pl/api/exchangerates/tables/A?format=xml"
r = requests.get(path)
#print(r.content)
with open('tab.xml','wb') as f:
    f.write(r.content)

from xml.etree import ElementTree

tree = ElementTree.parse('tab.xml')
root = tree.getroot()
#print(root.findall(".//Rate"))
date = root.find(".//EffectiveDate").text
nr = root.find(".//No").text
#print(date)

tabela = []
for element in root.findall(".//Rate"):
    waluta = []
    waluta.append(element.find("Currency").text)
    waluta.append(element.find("Code").text)
    waluta.append(element.find("Mid").text)
    tabela.append(tuple(waluta))

for element in tabela:
    print(element)

baza = mysql.connector.connect(host='localhost', user='root', password='', database='kantor')
kursor = baza.cursor()

kursor.execute("select * from kursy")
last = kursor.fetchall()

if len(last) == 0 or date != str(last[len(last)-1][1]):
    for rekord in tabela:
        if rekord[1] == "USD":
            kursor.execute("INSERT INTO usd VALUES ('" + nr + "','" + date + "'," + rekord[2]+");")
            baza.commit()
        if rekord[1] == "GBP":
            kursor.execute("INSERT INTO gbp VALUES ('" + nr + "','" + date + "'," + rekord[2] + ");")
            baza.commit()
        if rekord[1] == "EUR":
            kursor.execute("INSERT INTO eur VALUES ('" + nr + "','" + date + "'," + rekord[2] + ");")
            baza.commit()

        kursor.execute("INSERT INTO kursy VALUES ('"+nr+"','"+date+"','"+rekord[1]+"',"+rekord[2]+");")
        baza.commit()


