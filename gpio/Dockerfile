FROM arm32v6/alpine:3.6

RUN mkdir -p /usr/src/app
WORKDIR /usr/src/app

RUN apk add --update --no-cache python build-base nodejs nodejs-npm

COPY ./package.json /usr/src/app/

RUN npm install

EXPOSE 7695

COPY ./server.js /usr/src/app/

CMD ["node", "server.js"]
