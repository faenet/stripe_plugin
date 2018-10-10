# STRUCTURE

**plugin_anyname.zip** 	The name of the zip file - can be anything you wish.  
  
It contains one folder - rename to match the Stripe account, eg **albion_os_eb_stripe**  
## Folder contents:
**os_stripe.xml**		Rename to eg **albion_os_stripe.xml**  
**os_stripe.php**		Rename to eg **albion_os_stripe.php**
	
# Code modification

## Edit .xml file
**Edit the xml tags to match the plugin and also update the title:**
```
<name>albion_os_stripe</name>

<title>Stripe-Albion</title>
```	
**You can also edit the version number and description:**
```
<version>3.5.0a</version>
<description>Stripe Payment Plugin For Events Booking Extension (Albion)</description>
```
**Edit the xml file tag to match the php filename:**	
```
<files>  
  <filename>albion_os_stripe.php</filename>
</files>
``` 

## Edit .php file
Edit the class constructor name to match the plugin name:

**Change** class os_stripe extends RADPaymentOmnipay **to** class albion_os_stripe extends RADPaymentOmnipay


## Create plugin as Zip
All changed files should be packaged as per *Structure* above and then can be loaded via the **Payment Plugins** option in EventBooking back-end.