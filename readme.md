单本书籍queue队列
php7.1 artisan queue:work --queue=bookSpider --tries=3 --timeout=60 --sleep=3
书籍分类queue队列
php7.1 artisan queue:work --queue=categorySpider --tries=3 --timeout=60 --sleep=3
重启队列
php7.1 artisan queue:restart


php7.1 artisan queue:work --queue=chapeSpider,categorySpider,bookSpider  --timeout=60 &


…or create a new repository on the command line

echo "# dq" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin https://github.com/jilangsanqian/dq.git
git push -u origin master

…or push an existing repository from the command line

git remote add origin https://github.com/jilangsanqian/dq.git
git push -u origin master
