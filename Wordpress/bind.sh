plugin=transaction-respond
src=$HOME/src/Transaction-Responder/Wordpress
site=/var/www/site.tld/htdocs/wp-content/plugins

sudo mkdir -p $site/$plugin
sudo mount --bind $src/$plugin $site/$plugin
