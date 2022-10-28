<template is="layouts/app">
    <card>
        <l-form :action="route('users.update', $user->id)" method="put">
            <form-group type="file" label="Imagine profil" name="image" :value="$user->profilePicture" preview="true" :error="$errors->first('image')"></form-group>
            <form-group type="text" label="Nume" name="name" :value="$user->name" :error="$errors->first('name')"></form-group>
            <form-group type="email" label="Email" name="email" :value="$user->email" :error="$errors->first('email')"></form-group>
            <form-group type="textarea" label="Descriere" name="description" :value="$user->description" :error="$errors->first('description')" rows="7"></form-group>
            <div class="text-end">
                <button class="btn btn-success">Update</button>
            </div>
        </l-form>
    </card>
</template>