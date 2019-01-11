<template>
  <div>
      <!--<div class="field">-->
          <!--<label class="label">Task Title</label>-->
          <!--<div class="control">-->
              <!--<input v-model="article.title" type="text" class="input" name="title">-->
          <!--</div>-->
      <!--</div>-->
      <!--<div class="field">-->
          <!--<label class="label">Task Description</label>-->
          <!--<div class="control">-->
          <!--<textarea v-model="article.body" name="body" cols="30" rows="10" class="textarea">-->
      <!--</textarea>-->
          <!--</div>-->
      <!--</div>-->
      <!--<div class="level is-mobile">-->
          <!--<div class="level-left"></div>-->
          <!--<div class="level-right">-->
              <!--<button type="button" class="button is-success level-item" v-on:click="addArticle">Save</button>-->
              <!--<button type="button" class="button is-danger level-item">Cancel</button>-->
          <!--</div>-->
      <!--</div>-->
      <!--<nav>-->
        <!--<ul class="pagination">-->
            <!--<li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">-->
                <!--<a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a>-->
            <!--</li>-->
             <!--<li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>-->

            <!--<li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">-->
                <!--<a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a>-->
            <!--</li>-->
        <!--</ul>-->
      <!--</nav>-->
      <div class="card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
          <h3>{{article.title}}</h3>
          <p>{{article.body}}</p>
          <button class="button is-info" @click="editArticle(article)">Edit</button>
          <button class="button is-warning" @click="deleteArticle(article.id)">Delete</button>
      </div>
      <div class="columns">
          <div class="column is-narrow">
              <b-pagination
                      :total="total"
                      :current.sync="current"
                      :order="order"
                      :size="size"
                      :simple="isSimple"
                      :rounded="isRounded"
                      :per-page="perPage"
                      @change="changePage">
              </b-pagination>
          </div>
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
                current_page: '',
                total: '',
                current: '',
                perPage: 5,
                order: 'is-centered',
                size: '',
                isSimple: false,
                isRounded: false
            }
        },
        created() {
            this.fetchArticles();
        },
        methods: {
            changePage(iPage) {
                this.fetchArticles('/api/articles?page=' + iPage);
            },
            fetchArticles(page_url) {
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
                this.current = meta.current_page;
                this.total = meta.total;
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