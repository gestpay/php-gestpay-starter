# Example payment via Gestpay Payment Page in PHP 

This repository is an example project to show how to implement a payment via Gestpay payment page. 

The payment process is explained in [Gestpay Docs - Getting Started](http://docs.gestpay.it/gs/super-quick-start-guide.html) - see in particular *Using Banca Sella Payment Page*.

## What's in this repository 

| File     | Description   | 
| ----------- | ------------ |
| `index.php` | is the main entry point for the application. tweaking this page you will be able to change the amount, or the currency, and so on. | 
| `response.php` | when the payment is completed, Gestpay will redirect to this file to show to the user the payment status. `response.php` will decrypt the encrypted string and then it will show the SOAP message received - in the form of an array. |
| `nusoap.php` | `NuSoap` is a SOAP library. PHP has SOAP built-in support from PHP5 and more, but if you use PHP4 you must use a library for this. We have chosen `NuSoap`. |
| `phpinfo.php` | A simple page to check your php version and your server software. |
| `README.md` | this file |

## How to start the example  

1. open the file `index.php` and change 

 ```
 $shopLogin = 'GESPAYXXXXX';
 ```

 with your `shopLogin`.  
2. start this webapp on a server with a public IP.
3. Connect to your [test merchant back-office](https://testecomm.sella.it/BackOffice/) and login 
4. In *Configuration* > *IP address*, insert the public IP of your server
5. In the same page click on *Response Address* and insert: 
	- *URL for positive response*: `<<your_server_address>>/response.php`
	- *URL for negative response*: `<<your_server_address>>/response.php`
	- *URL Server to Server*: `<<your_server_address>>/response.php`
6. Pay with one of the cards present in the *Notification* page. 
7. Once you have payed, you'll be redirected by Gestpay on `response.php` to see the outcome of the transaction. 

## Questions, Issues, etc. 

For any questions, open an issue on Github. 