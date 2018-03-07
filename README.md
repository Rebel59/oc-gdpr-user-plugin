# GDPR Compliant Rainlab.User
The new european GDPR data and privacy law mandates companies to protect user-sensitive data. The Rainlab.User plugins will almost always contain user sensitive data. This plugin automatically encrypts and decrypts your user data, so you don't have to do it manually.

## How does it work?
In the Settings of the CMS, under the users category you will find a new page called `GDPR Settings` with a single input field called `columns`. Each column you will enter here (space separated) will automatically encrypted and decrypted.

### Encryption
The plugins loops through the filled in column names, and uses the `Crypt` library to encrypt the fields during the `beforeSave` event. You do not need to manually encrypt values. 

### Decryption
The plugins loops through the filled in column names, and uses the `Crypt` library to decrypt the fields during the `afterFetch` event. You do not need to manually decrypt values.
Decryption takes places inside a try-catch, as it will throw errors if it tries to decrypt a field that is not encrypted.

## Installation and first use
At the time of writing the installation of this plugin does not automatically encrypt values that are already stored in the database. Each value needs to be saved once. 
