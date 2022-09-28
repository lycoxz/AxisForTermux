#! /usr/bin/bash
null="> /dev/null 2>&1"
g="\033[1;32m"
r="\033[1;31m"
b="\033[1;34m"
w="\033[0m"
echo ""

echo -e $b"➤ "$w"Axis For Termux"
echo ""

echo -e $b"➤ "$w" prepare for installing dependencies ..."
echo ""

echo -e $b"➤ "$w" installing pacakge: "$g"php"$w
pkg install php
echo ""

echo -e $b"➤ "$w" installing pacakge: "$g"php curl"$w
pkg install php curl
echo ""

cd $HOME/AxisForTermux
sleep 2
php apiaxis.php
clear
