## Installation guide
 - Clone this repository
 - Run `composer install`
 - Create a database
 - Change suitable configuration in the .env file. (*you need to rename .env.example first!*)
 - Run `php artisan migrate` to create database tables

 **Note:** *Don't forget to change mail server settings in the .env file, otherwise e-mails won't be sent.*

## Automated tests using PHPUnit

- Enter project folder and run `vendor/bin/phpunit`

**Note:** *Using sample@gmail.com as a not unique e-mail address (needs to be created before to simulate tests).*

## Test Directions:

#### Recipients:

 - Go to: http://localhost/recipient and click on the "New Recipient" button.
 - Create as many recipients as you like.
 - It is possible to edit or remove recipients, if needed.
 - All the valid vouchers of a specific user can be accessed by clicking on the "eye button" on this screen.

**Note:** *You can't delete an user if the voucher was already used (just to keep historic).*

#### Special Offer

 - Go to: http://localhost/special-offer and click on the "New Special Offer" button.
 - As soon as a valid special offer is created, one voucher is created for each recipient and the recipients will be notified by e-mail.
 - All the vouchers of a special offer are available clicking on the "eye button" on this screen.

#### Vouchers
 - You can delete a specific voucher using the "trash button" or mark it as used using the "eye button" on this screen.
 - You can resend a specific voucher to the recipient using the "mail button".

 **Note:** *You can only do the actions above if the voucher is unused.*

## API:

#### Vouchers
  - You can set a voucher as used by acessing: http://localhost/api/json/confirm-voucher/[voucher_code]/[email]/[date] replacing the parameters and brackets to reasonable data.

  **Note:** *Date is optional and if no data is informed it's going to use today's date. First time is accessed it's going to return valid or invalid and some other relevant information, after the voucher is marked as used, status is going to be replaced to "Already been used".*

  - You can access all the valid vouchers of an specific recipient accessing: http://localhost/api/json/vouchers/[email] replacing the parameters and brackets to reasonable data.

**Postman Collection:** (https://www.getpostman.com/collections/f52821927a236874e20b)

## Database Schema

![ERD](https://github.com/gilbertogm85/voucher-code/blob/master/public/erd.png)
