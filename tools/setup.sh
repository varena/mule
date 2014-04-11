#!/bin/bash
#
# Configuration script to be run when a new client is first cloned

FULL_NAME=`readlink -e $0`
TOOLS_DIR=`dirname $FULL_NAME`
ROOT_DIR=`dirname $TOOLS_DIR`
cd $ROOT_DIR
echo "The root of your client appears to be $ROOT_DIR"

# Create a copy of the config file unless it already exists
if [ ! -e mule.conf ]
then
  echo "* copying mule.conf.sample to mule.conf"
  cp mule.conf.sample mule.conf
else
  echo "* mule.conf already exists, skipping"
fi

# Make some directories world-writable
echo "* running chmod on the templates_c directory"
chmod 777 templates_c

# Symlink hooks unless they already exist
if [ ! -e .git/hooks/pre-commit ]; then
  echo "* symlinking tools/git-hooks/pre-commit.php as .git/hooks/pre-commit"
  ln -s $ROOT_DIR/tools/git-hooks/pre-commit.php .git/hooks/pre-commit
else
  echo "* .git/hooks/pre-commit already exists, skipping"
fi

if [ ! -e .git/hooks/post-merge ]; then
  echo "* symlinking tools/git-hooks/post-merge.sh as .git/hooks/post-merge"
  ln -s $ROOT_DIR/tools/git-hooks/post-merge.sh .git/hooks/post-merge
else
  echo "* .git/hooks/post-merge already exists, skipping"
fi
