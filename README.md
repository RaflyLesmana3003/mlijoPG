# mlijo.id payment gateway

## installation
1. `git clone project`
2. for windows `copy .env.example .env`, for ubuntu `cp .env.example .env`
3. `composer install`
4. `php artisan migrate`
5. then `php artisan migrate`

## feature
1. midtrans payment gateway
2. midtrans iris create payout (creators)

## setup
you can change midtrans key in `.env` file
    
    MIDTRANS_CLIENTKEY=
    MIDTRANS_SERVERKEY=
    MIDTRANS_IS_PRODUCTION= true

    MIDTRANS_IRIS_CREATOR_API_KEY=
    MIDTRANS_IRIS_CREATOR_PASSWORD=
    
    MIDTRANS_IRIS_APPROVER_API_KEY=
    MIDTRANS_IRIS_APPROVER_PASSWORD=
## dokumentasi
[Dokumentasi](https://docs.google.com/presentation/d/1pSHbV7xhLhjy6VAFg970agH6Y9PBBmXOWimX7Y9o2Js/edit?usp=sharing)
   
    
## midtrans notification setup
your website must be hosting already
1. go to `production environment -> settings -> configuration`
2. add `base_url/notification/handler`

## midtrans iris notification setup
your website must be hosting already
1. go to `settings -> notification`
2. add `base_url/iris/notification/handler`

## source 
1. midtrans https://azishapidin.com/blog/menggunakan-payment-gateway-midtrans-di-laravel/
2. export excel https://www.malasngoding.com/export-excel-laravel/
3. export pdf https://www.malasngoding.com/membuat-laporan-pdf-dengan-dompdf-laravel/
