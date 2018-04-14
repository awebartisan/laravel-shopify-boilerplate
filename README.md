# laravel-shopify-boilerplate
An example project for creating shopify apps with Laravel
I created this repository to scratch my own itch, almost every Shopify app needs a Shopify API wrapper, a ShopifyController which
handles App Installation process, an App Uninstall Webhook , a Script Tag on Storefront. Instead of doing all these steps every time
why not make an App Skeleton project, or Boilerplate code which makes it easy to get started :)

<strong>#Note :</strong> Files, naming conventions etc are only my preference, these are not standards, you can use your own approach and even suggest 
me good coding approaches on how to do things.

<strong>#Note : </strong> This project uses <strong>Oseintow/Laravel-Shopify</strong> API wrapper for making Shopify API calls.

Steps : 

1- Download this project and install dependencies using composer<br>
2- Provide your Shopify API KEY and API SECRET in ENV ( config/shopify.php)<br>
3- Provide your Callback Redirect URI in .env file<br>
4- Manage your scopes in ( config/shopify.php)<br>
5- Create your database and Run Migrations<br>

<strong>#For your Information</strong>
1- This app uses Uptown CSS which makes our App's UI same as Shopify's UI. You can replace it with Bootstrap etc.<br>
2- This app uses jQuery. ( added as CDN)<br>
3- Script that is added to Storefront of Shop can be found under (public/storefront.js)<br>
<br>
Improvements are welcome :)<br>
