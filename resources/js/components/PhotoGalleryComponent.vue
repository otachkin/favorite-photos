<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="spinner-border" role="status" v-if=!photos> </div>
                <div class="gallery">
                    <div class="gallery-panel" v-for="photo in photos" :key="photo.id">
                        <img :src="photo.thumbnailUrl">
                        <button v-if="photo.favorite" type="button" class="btn btn-light" @click="favorite(photo)">
                            Delete from favorite
                        </button>
                        <button v-if="!photo.favorite" type="button" class="btn btn-primary" @click="favorite(photo)">
                            Add to favorite
                        </button>
                    </div>
                </div>
                <ul class="pgn" v-if="resultCount > itemsPerPage">
                    <li v-for="pageNumber in totalPages" v-if="showPage(pageNumber)">
                        <a href="#" @click="setPage(pageNumber)"  :class="pageClass(pageNumber)">{{ pageNumber }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

    import VueRouter from 'vue-router';

    Vue.use(VueRouter);

    const router = new VueRouter({
        routes: [
            { path: '/home'},
        ],
        mode: 'history'
    });

    export default {
        name: 'Gallery',
        router,
        data() {
            return {
                photos : null,
                currentPage: 1,
                itemsPerPage: 30,
                resultCount: null
            };
        },
        created() {
            this.currentPage = router.currentRoute.query.page ? router.currentRoute.query.page : 1;
            this.getPhotos();
        },
        computed: {
            totalPages() {
                return Math.ceil(this.resultCount / this.itemsPerPage)
            }
        },
        methods: {
            getPhotos() {
                this.photos = null;
                window.axios.get('/api/photos?page='+this.currentPage).then(({data}) => {
                    this.resultCount = data.total;
                    this.photos = data.photos;
                });
            },
            //Mark photo favorite
            favorite(photo){
                console.log(photo);
                window.axios.post('/api/photos/favorite', photo).then(({data}) => {
                    photo.favorite = data.added_to_favorite;
                });
            },
            //Pagination
            //Change page
            setPage(pageNumber) {
                this.currentPage = pageNumber;
                router.push('/home/?page='+pageNumber);
                this.getPhotos();
            },
            //Display page number
            showPage(pageNumber) {
                return Math.abs(pageNumber - this.currentPage) < 3 || pageNumber === this.totalPages || pageNumber === 1;
            },
            //Page class definition
            pageClass(pageNumber){
                return {
                    current: this.currentPage == pageNumber,
                    last: (pageNumber === this.totalPages && Math.abs(pageNumber - this.currentPage) > 3),
                    first:(pageNumber === 1 && Math.abs(pageNumber - this.currentPage) > 3)
                }
            }
        }
    };
</script>

<style>
    .gallery-panel .btn {
        margin-top: 15px;
    }

    .pgn a {
        font-size: 28px;
        color: #999;
    }
    .pgn .current {
        color: red;
        text-decoration: underline;
    }
    .pgn ul {
        padding: 0;
        list-style-type: none;
    }
    .pgn li {
        display: inline;
        margin: 5px 5px;
    }

    .pgn a.first::after {
        content:'...'
    }

    .pgn a.last::before {
        content:'...'
    }
</style>
