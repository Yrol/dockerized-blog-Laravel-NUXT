# Image
FROM node:14.16.1-alpine

USER node

# Set up work directory
WORKDIR /var/www/client

RUN npm install

# Configure host
ENV HOST 0.0.0.0

# Init command
CMD ["sh", "-c", "npm run dev"]