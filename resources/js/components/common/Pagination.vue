<template>
    <nav aria-label="Pagination">
        <ul class="pagination">
            <li class="page-item" v-bind:class="[{disabled: !pagination.prev}]">
                <a class="page-link" href="javascript:void(0)" aria-label="Previous" @click="fetchList(pagination.first)">
                    <span aria-hidden="true">First</span>
                    <span class="sr-only">First</span>
                </a>
            </li>
            <li class="page-item" v-bind:class="[{disabled: !pagination.prev}]">
                <a class="page-link" href="javascript:void(0)" aria-label="Previous" @click="fetchList(pagination.prev)">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>

            <template v-if="pagination.last_page <= 6">
                <div v-for="(n) in pagination.last_page" :key="n">
                    <li class="page-item" v-bind:class="[{active: n == pagination.current_page}]"><a class="page-link" href="javascript:void(0)" @click="fetchList(n)">{{ n }}</a></li>
                </div>
            </template>

            <template v-else>
                <template v-if="pagination.current_page >= 4">
                    <template v-if="pagination.current_page <= (pagination.last_page - 4)">
                        <li class="page-item" ><a class="page-link" href="javascript:void(0)">...</a></li>
                        <li class="page-item" ><a class="page-link" href="javascript:void(0)" @click="fetchList(pagination.current_page - 1)">{{ (pagination.current_page -1 ) }}</a></li>
                        <li class="page-item active"><a class="page-link" href="javascript:void(0)" disabled>{{ pagination.current_page }}</a></li>
                        <li class="page-item" ><a class="page-link" href="javascript:void(0)" @click="fetchList(pagination.current_page + 1)">{{ (pagination.current_page + 1) }}</a></li>
                        <li class="page-item" ><a class="page-link" href="javascript:void(0)" >...</a></li>
                    </template>
                </template>

                <template v-if="pagination.current_page < 4">
                    <li v-for="(n) in 4" :key="n" class="page-item" v-bind:class="[{active: n == pagination.current_page}]"><a class="page-link" href="javascript:void(0)" @click="fetchList(pagination.path + '?page=' + n)">{{ n }}</a></li>
                    <li class="page-item" ><a class="page-link" href="javascript:void(0)" disabled>...</a></li>
                </template>

                <template v-if="pagination.current_page > (pagination.last_page - 4)">
                    <li class="page-item" ><a class="page-link" href="javascript:void(0)" disabled>...</a></li>
                    <li v-for="(n) in 4" :key="n" class="page-item"
                        v-bind:class="[{active: (pagination.last_page - 4 + n) == pagination.current_page}]">
                        <a class="page-link" href="javascript:void(0)"
                           @click="fetchList(pagination.last_page - 4 +  n)">
                            {{ pagination.last_page - 4 + n }}
                        </a>
                    </li>
                </template>
            </template>

            <li class="page-item" v-bind:class="[{disabled: !pagination.next}]">
                <a class="page-link" href="javascript:void(0)" aria-label="Next" @click="fetchList(pagination.next)">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            <li class="page-item" v-bind:class="[{disabled: !pagination.next}]">
                <a class="page-link" href="javascript:void(0)" aria-label="Next" @click="fetchList(pagination.last)">
                    <span aria-hidden="true">Last</span>
                    <span class="sr-only">Last</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    props: {
        pagination: Object,
        fetchList: Function,
    },
    data() {
        return {

        }
    },
    mounted() {

    },

    methods: {
        makePagination(links) {
            let getLink = {
                first: 1,
                current_page: links.current_page,
                last_page: links.last_page,
                last: links.last_page,
                next: links.current_page == links.last_page ? 1 : links.current_page + 1,
                prev: links.current_page == 1 ? links.last_page : links.current_page - 1,
                path: links.path
            }
            this.pagination = getLink;
            this.$emit('event_pagination', this.pagination);
        },
    },
    watch: {
        pagination: {
            handler: function () {
                console.log('something changed')
            },
            deep: true
        }
    }
}
</script>
