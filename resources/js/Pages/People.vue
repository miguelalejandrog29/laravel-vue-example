<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ResponsiveTable from '@/Components/ResponsiveTable.vue';
import TextAreaInput from '@/Components/TextAreaInput.vue';
import TextInput from '@/Components/TextInput.vue';
import { People } from '@/Interfaces/IPeople';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import { onMounted, ref } from 'vue';

const props = defineProps<{
    tableData: { type: Array<People>, required: true };
    people?: People;
}>();

const tableHeaders = {
    dni: "DNI",
    name: "Name",
    last_name: "Last Name",
    phone: "Phone",
    address: "Address",
    created_at: "Created at",
    updated_at: "Updated at"
}

const form = useForm<People>({
    id: 0,
    dni: '',
    name: '',
    last_name: '',
    phone: '',
    address: ''
});

const editMode = ref<boolean>(false);

const submit = () => {
    if (!editMode.value) {
        form.post(route('people.store'), {
            onSuccess: () => {
                form.reset();
            },
        });
    }
    else {
        form.put(route('people.update', [form.id]), {
            onSuccess: () => {
                form.reset();
                editMode.value = false;
            },
        });
    }

};

onMounted(() => {
    if (props.people) {
        editMode.value = true;
        form.id = props.people?.id;
        form.dni = props.people?.dni;
        form.name = props.people?.name;
        form.last_name = props.people?.last_name;
        form.phone = props.people?.phone;
        form.address = props.people?.address;
    }
});

</script>

<template>

    <Head :title="trans('People')" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ trans("People") }}</h2>
        </template>

        <div class="flex flex-col sm:justify-center items-center pt-12 mt-5 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-2xl mt-1 px-6 py-2 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <form @submit.prevent="submit">
                    <input type="hidden" v-model="form.id" />
                    <div>
                        <InputLabel for="dni" :value="trans('DNI')" />

                        <TextInput id="dni" type="text" class="mt-1 block w-full" v-model="form.dni" required autofocus
                            autocomplete="dni" />

                        <InputError class="mt-2" :message="form.errors.dni" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="name" :value="trans('Name')" />

                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required
                            autocomplete="name" />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="last_name" :value="trans('Last name')" />

                        <TextInput id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name"
                            required autocomplete="last_name" />

                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="phone" :value="trans('Phone')" />

                        <TextInput id="phone" type="tel" class="mt-1 block w-full" v-model="form.phone" required
                            autocomplete="phone" />

                        <InputError class="mt-2" :message="form.errors.phone" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="address" :value="trans('Address')" />

                        <TextAreaInput id="address" class="mt-1 block w-full" v-model="form.address" required />

                        <InputError class="mt-2" :message="form.errors.address" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing" v-text="trans('Save')">
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

        <div class="flex flex-col sm:justify-center items-center">
            <div class="w-full sm:max-w-7xl md:max-w-2xl lg:max-w-4xl my-6">
                <ResponsiveTable v-bind:table-headers="tableHeaders" v-bind:table-data="tableData"
                    v-bind:edit-route="String('people.show')" v-bind:delete-route="String('people.destroy')">
                </ResponsiveTable>
            </div>
        </div>

    </AuthenticatedLayout>
</template>