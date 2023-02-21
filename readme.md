REST API (Nette framework)
===================================

This is example of REST API implemented in Nette framework.

API has been built to manipulate contacts.

Intro
------------
There are 2 basic tables: 
- persons
- phones

Each person could have 0 to N phone numbers.
Phone number without person is not allowed.
Each "contact" should have person and at least 1 phone number.

Methods
------------

Implemented methods:
- GET
- POST
- DELETE

Other methods are not implemented.

Endpoints
------------

GET

```
/api/
```

send back all contacts in JSON. Persons without phone number are not included in that list.


```
/api/name/<personName>

example:
/api/name/Alfons
```
send back Persons with that name in JSON.


```
/api/surname/<personSurname>

example:
/api/surname/Smith
```
send back Persons with that surname in JSON.


```
/api/email/<personEmail>

example:
/api/email/smith@email.com
```
send back Person with that email in JSON. Emails are unique.


```
/api/id/<personId>

example:
/api/id/34
```
send back Person with that id in JSON. Id is primary key.


```
/api/phone/<personPhone>

example:
/api/phone/755899699
```
send back Person with that phone number in JSON.
<br><hr><br>

POST

```
/api/insertdata
```

Requested body:
```json
[{
    "name" : "Dan",
    "surname" : "Newman",
    "email" : "newman@email.com",
    "phone" : "789554222" 
},
{
    "name" : "Judith",
    "surname" : "Tate",
    "email" : "tate@email.com",
    "phone" : "777888999" 
}]
```

OR

```json
{
    "name" : "Adam",
    "surname" : "Fitch",
    "email" : "fitch@email.com",
    "phone" : "123456789" 
}
```
to upload data to server. Persons surname and email are mandatory.
<br><hr><br>

DELETE

```
/api/deletedata/person/<id>

example:
/api/deletedata/person/34
```
This removes Person by id and also all his phone numbers. If Person with that id not exists, nothing happens.

```
/api/deletedata/phone/

example:
/api/deletedata/phone/735951456
```
This removes only current number. If not exists, nothing happens.


