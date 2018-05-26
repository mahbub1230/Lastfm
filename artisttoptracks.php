<?php
$ArtistName=$_REQUEST['artistName'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Top Track List</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
</head>
<body>
<div id="app" style="text-align: -webkit-center;">
    <h1>Top Tracks List By Country</h1>
    <div class="cols cols1" style="width: 50%">
        <div class="col">
            <table class="res-table">
                <tr>
                    <th>Track Name</th>
                    <th> Image</th>
                </tr>
                <tr v-for="result in results">
                    <td data-th="Table Option 1">{{ result.name }}</td>
                    <td data-th="Table Option 2" v-for="image in result.image" v-if="image.size === 'medium'">
                        <img v-if="image.size === 'medium'" v-bind:src="image['#text']" >
                    </td>
                </tr>
            </table>
        </div>
    </div>


   <!-- <div class="row">
        <div class="columns medium-4" v-for="result in results">
            <div class="card">
                <div class="card-section">
                    <p> {{ result.name }} </p>
                </div>
                <div class="card-divider">
                    <p>{{ result.url }}</p>
                </div>
                <div class="card-section" v-for="image in result.image">
                    <img v-if="image.size === 'medium'" v-bind:src="image['#text']" >
                </div>
            </div>
        </div>
    </div>-->
</div>
<script type="application/javascript">
    var vm = new Vue({
        el: '#app',
        data() {
            return {
                results: null,
                ArtistName: '<?php echo $ArtistName?>'
            }

        },
        mounted () {
            this.fetchData();
        },
        methods: {
            fetchData: function () {
                var bodyFormData = new FormData();
                bodyFormData.set('artistName', this.ArtistName);
                axios
                 ({
                    method: 'post',
                    url: 'src/getTopTracksByArtist.php',
                    data: bodyFormData,
                    config: { headers: {'Content-Type': 'multipart/form-data' }}
                })
                    .then(response => {
                        if(!response.data.error) {
                            this.results = response.data.toptracks.track
                            this.errored = null
                        }
                        else
                        {
                            this.results=null
                            this.errored=response.data.message
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        this.errored = error.message
                    })
                    .finally(() => this.loading = false)
            }
        }
    });
</script>
</body>
