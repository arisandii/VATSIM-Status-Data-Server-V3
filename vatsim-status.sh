#!/bin/sh

# At line 8, change your current working directory
# to parser's directory. Otherwise, it won't work correctly.
# Consult with your hosting provider about Python 3 path.
# Then change "/opt/alt/python36/bin/python3" to correct path.

cd ~/job/api
/opt/alt/python36/bin/python3 get-data.py
/opt/alt/python36/bin/python3 app.py