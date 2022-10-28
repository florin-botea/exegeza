<template is="layouts/app">
    <card>
        <tabs :tabs="['general' => 'General', 'account' => 'Cont']" :value="old('tab', 'general')">
            <div slot="tab-pane">
                <section class="row">
                    <div p-logged="$user->id" class="col-12 d-flex justify-content-between align-items-center">
                        <label class="tab-pane-title">Profil</label>
                        <a :href="'/users/'.auth()->id().'/edit'" class="btn btn-sm btn-primary py-1 my-2">
                            Edit <i class="fas fa-edit"></i>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <figure class="bg-secondary">
                            <img class="mx-auto w-100" :src="$user->profilePicture">
                        </figure>
                    </div>
                    <div class="col-sm-6">
                        <table class="w-full h5">
                            <tr>
                                <td> Nume: </td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td> Email: </td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td> Bio: </td>
                            </tr>
                            <tr>
                                <td colspan="2">{{ $user->description }}</td>
                            </tr>
                        </table>
                    </div>
                </section>
            </div>
            <div slot="tab-pane">
                <section>
                    <label class="tab-pane-title">Schimbare parola</label>
                    <l-form :action="route('change-password', $user->id)" method="put">
                        <input name="tab" value="account" hidden>
                        <form-group type="password" label="Parola curenta" name="password"></form-group>
                        <form-group type="password" label="Noua parola" name="password_new"></form-group>
                        <form-group type="password" label="Noua parola (confirmare)" name="password_new_confirmation"></form-group>
                        <div class="text-end">
                            <button class="btn btn-sm btn-warning">Update</button>
                        </div>
                    </l-form>
                </section>
            </div>
        </tabs>
    </card>
</template>