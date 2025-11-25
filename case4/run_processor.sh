#!/bin/sh

docker rm -f processor1

docker run -d \
    --name processor1 \
    --network mynet \
    -v $(pwd)/files:/data \
    -v $(pwd)/script:/script \
    python:3.9-slim \
    /bin/sh -c "pip install mysql-connector-python && python /script/importer.py"
