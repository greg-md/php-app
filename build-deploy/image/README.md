# Build and Deploy

Steps: http://blog.shippable.com/build-a-docker-image-and-push-it-to-docker-hub

1. docker login --username=yourhubusername --password=yourpassword
2. docker build -t $DOCKER_ACC/$DOCKER_REPO:$IMG_TAG .
3. docker push $DOCKER_ACC/$DOCKER_REPO:$IMG_TAG
