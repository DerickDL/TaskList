<template>
  <div>
      <h2>Articles</h2>
      <form class="mb-3" @submit.prevent="addArticle" >
          <div class="form-group">
              <input v-model="article.title" type="text" class="form-control" placeholder="Title" name="title">
          </div>
          <div class="form-group">
              <textarea v-model="article.body" placeholder="Body" name="body" id="body" cols="30" rows="10" class="form-control">
              </textarea>
          </div>
          
          <button type="submit" class="btn btn-light btn-block">Save</button>
      </form>
      <nav>
        <ul class="pagination">
            <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                <a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a>
            </li>
             <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>

            <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                <a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>
            </li>
        </ul>
      </nav>
      <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
          <h3>{{article.title}}</h3>
          <p>{{article.body}}</p>
          <button class="btn btn-warning mb-2" @click="editArticle(article)">Edit</button>
          <button class="btn btn-danger mb-2" @click="deleteArticle(article.id)">Delete</button>
      </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                articles: [],
                article: {
                    article_id: '',
                    title: '',
                    body: ''
                },
                article_id: '',
                pagination: {},
                edit: false,
                current_page: ''
            }
        },
        created() {
            this.fetchArticles();
        },
        methods: {
            fetchArticles(page_url) {
                console.log(page_url);
                let vm = this;
                page_url = page_url || '/api/articles';
                this.current_page = page_url;
                fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.articles = res.data;
                    vm.makePagination(res.meta, res.links);
                });
            },
            makePagination(meta, links) {
                console.log(meta);
                console.log(links);
                if (meta.current_page > meta.last_page) {
                    this.fetchArticles(links.last);
                } else {
                    let pagination = {
                        current_page: meta.current_page,
                        last_page: meta.last_page,
                        next_page_url: links.next,
                        prev_page_url: links.prev
                    };
                    this.pagination = pagination;
                }
            },
            deleteArticle(article_id) {
                if(confirm('Are you sure?')) {
                    fetch('api/article/' + article_id, {
                        method: 'delete'
                    })
                    .then(res => res.json)
                    .then(res => {
                        alert('Article removed!');
                        this.fetchArticles(this.current_page);
                    })
                    .catch(err => console.log(err));
                }
            },
            addArticle() {
                if (this.edit === false) {
                    fetch('api/article', {
                        method: 'post',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log(this.pagination.current_page);
                        this.article.title = '';
                        this.article.body = '';
                        alert('Article added!');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                } else {
                    fetch('api/article', {
                        method: 'put',
                        body: JSON.stringify(this.article),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.edit = false;
                        this.article.article_id = '';
                        this.article.title = '';
                        this.article.body = '';
                        alert('Article updated!');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                }
            },
            editArticle(article) {
                this.edit = true;
                this.article.article_id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;
            }
        }
    }
</script>