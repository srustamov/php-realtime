if test ! -f "$(pwd)/vendor/autoload.php"; then
   composer install
fi


/usr/bin/php $(pwd)/socket/server.php > /dev/null 2>&1 &
/usr/bin/php -S localhost:8000 -t $(pwd)/web > /dev/null  2>&1 #&



