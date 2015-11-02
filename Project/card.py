#!/usr/bin/python
import sys, os, base64, qrtools, SimpleCV, mysql.connector, logging

logging.basicConfig(filename='example.log',level=logging.DEBUG)

connection = mysql.connector.connect(host='localhost', user='root', password='kronos1234', database='cardtest')
cursor = connection.cursor()

#SELECT STATEMENT FOR subjectID from latest statement
add_subjectCard = ("INSERT INTO subjectCard (subjectID, cardID, position) VALUES (%(subjectID)s, %(cardID)s, %(position)s)")

card_query = ("SELECT cardID FROM card WHERE cardQR = %s AND experimentID = %s")

#Columns and Rows to Split By
COLS = 10
ROWS = 5

#Declare QRDecoder
qr_decoder = qrtools.QR()

#Data
imagename = sys.argv[1]
experimentid = int(sys.argv[2])
subjectid = int(sys.argv[3])
count = int(sys.argv[4])
numOfCards = 0
positionOfCard = 0
cardList = []

#Spliting the image
img = SimpleCV.Image(imagename)
img = img.grayscale()
images = img.split(COLS, ROWS)

for i in range(0, ROWS):
    for j in range(0, COLS):
        image_name = 'image{}.jpg'.format((i*COLS + j)+1)
        images[i][j].save(image_name)
        if qr_decoder.decode(image_name):
            numOfCards = numOfCards + 1
            positionOfCard = positionOfCard + 1
            cursor.execute(card_query, (qr_decoder.data, experimentid))
            result = cursor.fetchall()
            for row in result:
                cardid = row[0]
              #result = cursor.fetchone()
              #if result is not None:
            cardList.append({
                'subjectID': subjectid,
                'cardID': cardid,
                'position': positionOfCard,
            })
            print("Successfully read card")
        else:
            positionOfCard = positionOfCard + 1
            print("Unable to read card")

if len(cardList) == numOfCards:
    for card in cardList:
        try:
            cursor.execute(add_subjectCard, card)
            connection.commit()
            print("Successfully added card to DB")
        except mysql.connector.IntegrityError as err:
            print(err)
else:
    print "Failed!"

cursor.close()
connection.close()

#Delete Split Images
for i in range(0, ROWS):
    for j in range(0, COLS):
        image_name = 'image{}.jpg'.format((i*COLS + j)+1)
        os.remove(image_name)

#Delete Main Image
os.remove(imagename)