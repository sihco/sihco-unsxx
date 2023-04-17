#!/bin/bash

#///////////////////////////////////////////////////////////////////////////////////////////
echo "#############################################################"
echo "####### installsihco.sh de 14/Abril/2022 por FabianS7 #######"
echo "#############################################################"

echo "###"
echo "####"
echo "##### NUNCA EJECUTE install.sh en una computadora que no sea un ubuntu o debian (puede perder cosas)"
echo "####"
echo "### presione control-C para detener ahora o enter para continuar"
read lin

if [ "`id -u`" != "0" ]; then
  echo "Debe ejecutar como root"
  exit 1
fi
ruta=`pwd`

add-apt-repository ppa:ondrej/php
apt-get -y update
apt-get -y install python-software-properties 2>/dev/null
apt-get -y install software-properties-common 2>/dev/null

for i in id chown chmod cut awk tail grep cat sed mkdir rm mv sleep apt-get add-apt-repository update-alternatives; do
  p=`which $i`
  if [ -x "$p" ]; then
    echo -n ""
  else
    echo commando "$i" no encontrado
    exit 1
  fi
done
sleep 2

echo "$0" | grep -q "installsihco.*sh"
if [ $? != 0 ]; then
  echo "Haga que el script de instalación sea ejecutable (usando chmod) y ejecútelo directamente, como ./installsihco.sh"
else

if [ "$1" != "alreadydone" ]; then
  echo "Se recomienda que ejecute los comandos"
  echo "  apt-get update; apt-get upgrade"
  echo "por su cuenta antes de ejecutar este script. Si ya lo ha hecho,"
  echo "por favor ejecute el script como"
  echo "   ./installsihco.sh alreadydone"
  exit 1
fi

if [ ! -r /etc/lsb-release ]; then
  echo "Archivo /etc/lsb-release no encontrado. ¿Es esta una distribución similar a Ubuntu o Debian?"
  exit 1
fi
. /etc/lsb-release

echo "========= INSTALANDO SYSVINIT-UTILS ==========="
apt-get -y install sysvinit-utils
if [ $? != 0 ]; then
  apt-get -y install sysvutils
  if [ $? != 0 ]; then
    echo ""
    echo "ERROR al ejecutar apt-get: debe verificar si todos los paquetes necesarios están disponibles"
    exit 1
  fi
fi


echo "=============================================================="
echo "=========== COMPROBACIÓN DE OTROS SERVIDORES APT  ============"
echo "=============================================================="
echo "======= VERIFICANDO EL SERVIDOR APT de canonical.com  ========"
cd
grep -q "^[^\#]*deb http://archive.canonical.com.* $DISTRIB_CODENAME .*partner" /etc/apt/sources.list
if [ $? != 0 ]; then
  add-apt-repository "deb http://archive.canonical.com/ubuntu $DISTRIB_CODENAME partner"
fi

add-apt-repository ppa:ubuntu-toolchain-r/test

#para actualizacion
apt-get -y update
apt-get -y upgrade

echo "====================================================================="
echo "========== instalación de paquetes necesarios para sihco =========="
echo "====================================================================="

apt-get -y install apache2 \
  makepasswd php7.2-cli \
  php7.2 php7.2-pgsql postgresql postgresql-client postgresql-contrib quota sharutils \
  php7.2-gd php7.2-zip php7.2-xml php7.2-curl php7.2-json php7.2-intl php7.2-mbstring debootstrap schroot
if [ $? != 0 ]; then
  echo ""
  echo "ERROR al ejecutar apt-get: debe verificar si todos los paquetes necesarios están disponibles"
  exit 1
fi

apt-get -y autoremove
apt-get -y clean

for i in makepasswd useradd update-rc.d; do
  p=`which $i`
  if [ -x "$p" ]; then
    echo -n ""
  else
    echo commando "$i" no encontrado
    exit 1
  fi
done


touch /tmp/.sihco.tmp

echo "============================================================"
echo "================ configurando UP USER QUOTA  ==============="
echo "============================================================"

for i in `mount | grep gvfs | cut -d' ' -f3`; do
  umount $i
done

mount / -o remount
quotaoff -a 2>/dev/null
quotacheck -M -a
quotaon -a
setquota -u postgres 0 3000000 0 10000 -a
setquota -u nobody 0 500000 0 10000 -a
setquota -u www-data 0 1500000 0 10000 -a
echo "================================================================================================"
echo "================ Instalando sihco(Sistema de Historial Clinico Odontologico)  =================="
echo "================================================================================================"
#apache2
echo "dbserver=localhost" > /etc/sihco.conf
echo "sihcodir=/var/www/sihco" >> /etc/sihco.conf
chmod 644 /etc/sihco.conf
rm -rf /var/www/sihco
mkdir -p /var/www/sihco
cp -r $ruta/sihco /var/www/
chmod -R 777 /var/www/sihco
chown -R www-data.www-data /var/www/sihco
cp -f /var/www/sihco/tools/000-sihco.conf /etc/apache2/sites-available/000-sihco.conf
cd /etc/apache2/sites-available
a2ensite 000-sihco.conf
a2dissite 000-default.conf
/etc/init.d/apache2 restart

cp -f /var/www/sihco/tools/sihco-createdb.sh /usr/sbin/sihco-createdb

/usr/sbin/sihco-createdb
fi
echo "FIN DE LA INSTALACION"
echo "==== === =  = ====="
echo "==    =  ==== =================="
echo "=    === =  = ======================================================================================="
