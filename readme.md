单本书籍queue队列
php7.1 artisan queue:work --queue=bookSpider --tries=3 --timeout=60 --sleep=3
书籍分类queue队列
php7.1 artisan queue:work --queue=categorySpider --tries=3 --timeout=60 --sleep=3
重启队列
php7.1 artisan queue:restart







php7.1 artisan queue:work --queue=bookSpider  --timeout=60  &
php7.1 artisan queue:work --queue=categorySpider  --timeout=60 & 
php7.1 artisan queue:work --queue=chapeSpider  --timeout=60 &




php7.1 artisan queue:work --queue=chapeSpider,categorySpider,bookSpider  --timeout=60 &