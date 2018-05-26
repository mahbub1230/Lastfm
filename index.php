<!DOCTYPE html>
<html>
<head>
  <title>Music List</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
</head>
<body>
<div id="app">
	<div class="row" style="text-align: -webkit-center;">
        <div class="form-block form-inline" style="width: 50%">
            <div class="form-group">
                <label for="input1">Enter Country Name:</label>
                <input id="input1" class="form-control" type="text" v-model="txtCountryName">
                <span>{{errored}}</span>
            </div>
        </div>
        <h1>Band List By Country</h1>
        <div class="cols cols1" style="width: 50%">
            <div class="col">
                <table class="res-table">
                    <ul class="pagination">
                        <li><a href="#">Page</a></li>
                        <li v-for="n in numOfPages"><a href="" @click.prevent="setPage(n)">{{n}}</a></li>
                    </ul>
                    <tr>
                        <th>Band Name</th>
                        <th> Image</th>
                    </tr>
                    <tr v-for="result in computedAtrists">
                        <td data-th="Table Option 1">{{ result.name }}</td>
                        <td data-th="Table Option 2" v-for="image in result.image" v-if="image.size === 'medium'">
                            <a v-bind:href="'artisttoptracks.php?artistName='+result.name" target="_blank"> <img  v-bind:src="image['#text']" ></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!--<div class="columns medium-4" v-for="result in results">
					<div class="card">
					  <div class="card-section">
						<p> {{ result.name }} </p>
					  </div>
					  <div class="card-divider">
						<p>$ {{ result.url }}</p>
					  </div>
                        <div class="card-section" v-for="image in result.image">
                           <a v-bind:href="'artisttoptracks.php?artistName='+result.name" target="_blank"> <img v-if="image.size === 'medium'" v-bind:src="image['#text']" ></a>
                        </div>
					</div>
				</div>-->
	</div>
	</div>
</div>
<script type="application/javascript">
new Vue({
        el: '#app',
        data() {
			return {
                txtCountryName: 'Spain',
				results: null,
				errored: '',
                currentPage: 1,
                perPage: 5,
				loading: true
			}
				
        },
         watch: {
			 txtCountryName: function (newTxtCountryName, oldTxtCountryName) {
				 this.fetchData()
				 }
		 },
		 mounted () {
			 this.fetchData();
		/*axios
			.get("http://ws.audioscrobbler.com/2.0/?method=geo.gettopartists&country="+this.txtCountryName+"&api_key=ecf6927751fa4d74b943a809abf91015&format=json")
			.then(response => {
				this.results = response.data.topartists.artist
			})
			.catch(error => {
				console.log(error)
				this.errored = true
			})
      .finally(() => this.loading = false)*/
	  },
	  methods: {
          setPage(n) {
              this.currentPage = n;
          },
		  fetchData: function () {
              var bodyFormData = new FormData();
              bodyFormData.set('countryName', this.txtCountryName);
              this.errored = "loading......";
			  axios
              ({
                  method: 'post',
                  url: 'src/getArtistListByCountry.php',
                  data: bodyFormData,
                  config: { headers: {'Content-Type': 'multipart/form-data' }}
              })
			.then(response => {
				if(!response.data.error) {
                    this.results = response.data.topartists.artist
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
	  },
    computed: {
        offset() {
            return ((this.currentPage - 1) * this.perPage);
        },
        limit() {
            return (this.offset + this.perPage);
        },
        numOfPages() {
            if (this.results)
                return Math.ceil(this.results.length / this.perPage);
            else
                return 0;
        },
        computedAtrists() {
            if (this.results) {
                if (this.offset > this.results.length) {
                    this.currentPage = this.numOfPages;
                }
                return this.results.slice(this.offset, this.limit);
            }
            else
                return null;
        }
    }
        /*methods: {
			 fetchData: function () {
                fetch("http://ws.audioscrobbler.com/2.0/?method=geo.gettopartists&country="+this.txtCountryName+"&api_key=ecf6927751fa4d74b943a809abf91015&format=json"),
                    function (data) {
                        this.results = data;
						console.log(data);
                    }
            }
        }*/
		 
    });
</script>
</body>
</html>