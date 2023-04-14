#!/usr/bin/env bash

npm run build
docker build --platform linux/amd64 -t r.knspr.space/logsock:latest .
docker push r.knspr.space/logsock:latest
