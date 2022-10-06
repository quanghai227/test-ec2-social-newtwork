<template>
    <div class="flex justify-around items-center bg-gray-100 min-h-screen">
        <div class="row" style="margin: auto; width: 100%; height: 100%;">
            <div class="col-7 p-3" style="margin: auto">
                <img width="500" height="500" src="https://media.istockphoto.com/photos/south-port-beach-boardwalk-at-sunset-picture-id1239827155" alt="Social Network">
            </div>
            <div class="text-center col-5" style="margin: auto; width: 500px; height: 500px;">
                <h1 class="text-4xl font-semibold">
                    Social Network
                </h1>

                <div>
                    <template>
                        <router-link to="/login" class="btn btn-outline-primary">
                            Login
                        </router-link>
                        <router-link to="/register" class="btn btn-outline-success">
                            Register
                        </router-link>
                    </template>
                </div>

            </div>
        </div>
    </div>
</template>
