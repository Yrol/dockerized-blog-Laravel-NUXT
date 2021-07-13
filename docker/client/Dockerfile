# Image
FROM node:14.16.1-alpine

# Set up work directory
WORKDIR /var/www/client

# Configure host
ENV HOST 0.0.0.0

# Prod
#CMD ["sh", "-c", "npm install && npm run build && npm run start"]

# Dev
CMD ["sh", "-c", "npm install && npm run dev"]
