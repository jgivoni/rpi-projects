FROM arm32v6/alpine:3.6

RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

RUN apk add --update --no-cache python build-base nodejs nodejs-npm

RUN npm install rpio net

EXPOSE 7695

COPY ./server.js /usr/src/app/

CMD ["node", "server.js"]
