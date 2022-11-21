##DB setup
DEFINE INDEX alias ON TABLE user COLUMNS alias UNIQUE;
DEFINE INDEX email ON TABLE user COLUMNS email UNIQUE;

##SurrealConn
###My addings to Santiagos connector
The SurrealConn object is constructed by parsing an array with the following keys:
user
password
host
database
name_spacing
simplify (optional bool - will return the 'result' directly)

If status != OK, an error is thrown - inspired by pyMySql

Placeholders supported using "?" and ['someValue']
