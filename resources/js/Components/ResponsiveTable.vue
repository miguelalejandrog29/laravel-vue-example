<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { trans } from 'laravel-vue-i18n';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';

const props = defineProps({
    //Estructura de los datos a mostrar, formato {colName: "ColHeader"}
    tableHeaders: { type: Object, required: true },
    //Datos devueltos por el back
    tableData: { type: Object, required: true },
    //PrimaryKey de la tabla de la DB
    tableRowKeyName: {
        type: String,
        default(rawProps: String) {
            return 'id';
        }
    },
    editRoute: { type: String, required: true },
    deleteRoute: { type: String, required: true }
});

const table = ref<HTMLTableElement | null>(null);

function DeleteItem(id: number) {
    Swal.fire({
        title: trans('Seguro desea eliminar el registro?'),
        text: trans("No será posible revertir esto!"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: trans("Si, eliminarlo!")
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route(props.deleteRoute, [id]), {
                onSuccess: () => {
                    Swal.fire({
                        title: trans("Eliminado!"),
                        text: trans("El item ha sido eliminado."),
                        icon: "success",
                        toast: true,
                        position: 'bottom-end',
                        timer: 5000,
                        timerProgressBar: true,
                    })
                }
            }
            )
        }
    });
}

onMounted(() => {
});

defineExpose({});
</script>

<template>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" ref="table">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th v-for="header, i in props.tableHeaders" v-text="trans(header)" scope="col" class="px-6 py-3">
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">edit</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row, i in props.tableData" :key="row[props.tableRowKeyName]"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td v-for="col, i in Object.keys(props.tableHeaders)" v-text="row[col]"
                        v-bind:class="i == 0 ? 'px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white' : 'px-6 py-4'">
                    </td>
                    <td class="px-6 py-4 text-right">
                        <Link :href="route(props.editRoute, [row[props.tableRowKeyName]])" method="get"
                            v-text="trans('Edit')"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2">
                        </Link>
                        <a href="#" v-on:click="DeleteItem(row[props.tableRowKeyName])" v-text="trans('Delete')"
                            class="font-medium text-red-600 dark:text-red-500 hover:underline">
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</template>
