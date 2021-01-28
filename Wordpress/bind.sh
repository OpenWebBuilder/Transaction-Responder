this=transaction-responder
src=$HOME/src/Transaction-Responder/Wordpress
site=/var/www/site.tld/htdocs/wp-content/plugins

sudo mkdir -p $site/$this
sudo mount --bind $src/$this $site/$this
