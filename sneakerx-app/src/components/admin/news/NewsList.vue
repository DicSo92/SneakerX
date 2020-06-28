<template>
  <div class="full-width">
    <q-table
      title="Treats"
      :data="news"
      :columns="columns"
      :visible-columns="visibleColumns"
      row-key="id"
      selection="multiple"
      :selected.sync="selected"
      :loading="loading"
      class="NewsTable"
    >

      <template v-slot:top>
        <q-icon name="fiber_new" size="lg"/>

        <q-space/>

        <q-input borderless dense debounce="300" v-model="search" placeholder="Search" class="q-mr-md">
          <q-icon slot="append" name="search"/>
        </q-input>

        <q-select
          v-model="visibleColumns"
          multiple
          outlined
          dense
          options-dense
          :display-value="$q.lang.table.columns"
          emit-value
          map-options
          :options="columns"
          option-value="name"
          options-cover
          style="min-width: 150px"
        />
      </template>

      <template v-slot:header="props">
        <q-tr :props="props">
          <q-th auto-width>
            <q-checkbox v-model="props.selected" color="black"/>
          </q-th>
          <q-th
            v-for="col in props.cols"
            :key="col.name"
            :props="props"
            class="text-italic text-purple"
          >
            {{ col.label }}
          </q-th>
        </q-tr>
      </template>

      <template v-slot:body="props">
        <q-tr :props="props">
          <q-td>
            <q-checkbox v-model="props.selected" color="black"/>
          </q-td>
          <q-td key="id" :props="props" auto-width>
            {{ props.row.id }} #
          </q-td>
          <q-td key="image" :props="props" auto-width>
            <q-avatar rounded>
              <img :src="props.row.image ? props.row.image : 'statics/no-image.jpg'">
            </q-avatar>
          </q-td>
          <q-td key="title" :props="props">
            <div class="text-pre-wrap text-bold">{{ props.row.title }}</div>
          </q-td>
          <q-td key="content" :props="props">
            <div class="columnDescription" :class="!props.row.content ? 'text-red-5' : ''">
              {{props.row.content ? props.row.content : 'No content'}}
            </div>
          </q-td>
          <q-td key="subtitle" :props="props">
            <div class="text-pre-wrap text-bold">{{ props.row.subtitle }}</div>
          </q-td>
          <q-td key="published_date" :props="props" class="text-caption text-grey-7">{{ cFormatDate(props.row.published_date) }}</q-td>
          <q-td key="refLink" :props="props" auto-width>
            <q-btn outline size="sm" rounded color="primary" label="Official Page" @click="openExternalLink(props.row.refLink)"/>
          </q-td>
          <q-td key="created_at" :props="props" class="text-caption text-grey-7">{{ cFormatDate(props.row.created_at) }}</q-td>
          <q-td key="updated_at" :props="props" class="text-caption text-grey-7">{{ cFormatDate(props.row.updated_at) }}</q-td>
          <q-td key="published" :props="props" auto-width>
            <q-btn rounded size="xs" :color="props.row.published === 1 ? 'green-6' : 'red-7'"
                   :label="props.row.published === 1 ? 'published' : 'disable'"/>

          </q-td>
        </q-tr>
      </template>

      <template v-slot:no-data="{ icon, message, filter }">
        <div class="full-width row flex-center text-accent q-gutter-sm">
          <q-icon size="2em" name="sentiment_dissatisfied"/>
          <span>
            Well this is sad... {{ message }}
          </span>
          <q-icon size="2em" :name="search ? 'filter_b_and_w' : icon"/>
        </div>
      </template>

    </q-table>

  </div>
</template>

<script>
    import bus from '../../../utils/bus.js'
    import {QSpinnerGears, date, openURL} from 'quasar'


    export default {
        name: "NewsList",
        data() {
            return {
                news: [],
                loading: true,
                search: '',

                pagination: {
                    sortBy: 'id',
                    descending: false,
                    // page: 2,
                    rowsPerPage: 6
                    // rowsNumber: xx if getting data from a server
                },
                selected: [],
                visibleColumns: ['id', 'image', 'title', 'content', 'subtitle', 'published_date', 'published'],
                columns: [
                    {name: 'id', required: true, label: 'ID', field: row => row.id, align: 'left', sortable: true},
                    {name: 'image', align: 'center', label: 'Image', field: 'image'},
                    {name: 'title', align: 'left', label: 'Title', field: 'title', sortable: true},
                    {name: 'content', align: 'left', label: 'Content', field: 'content'},
                    {name: 'subtitle', align: 'left', label: 'Subtitle', field: 'subtitle', sortable: true},
                    {name: 'published_date', label: 'Published Date', field: 'published_date', sortable: true},
                    {name: 'refLink', label: 'Ref. Link', field: 'refLink', align: 'left'},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'updated_at', label: 'Updated At', field: 'updated_at', sortable: true},
                    {name: 'published', label: 'Published', field: 'published', align: 'center', sortable: true},
                ],
            }
        },
        created() {
            this.getNews()
        },
        mounted() {
            bus.$on('refreshNews', () => {
                this.getNews()
            })
        },
        watch: {
            selected (val) {
                this.$emit('selectedChange', val)
            },
        },
        methods: {
            openExternalLink(link) {
                openURL(link)
            },
            cFormatDate(Date) {
                return date.formatDate(Date, 'DD/MM/YY HH:mm')
            },
            getNews() {
                this.loading = true
                this.$axios.get('/api/admin/news')
                    .then(response => {
                        console.log(response)
                        this.news = response.data
                        this.loading = false
                    })
                    .catch(error => {
                        console.log('error')
                        console.log(error)
                        this.loading = false
                    })
            },

        },
    }
</script>

<style scoped lang="scss">
  #spinnerContainer {
    min-width: 10px;
  }
  .columnDescription {
    font-size: 0.85em;
    font-style: italic;
    max-width: 280px;
    white-space: normal;

    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .NewsTable {
    max-width: 100%;

    td:first-child {
      text-align: center;
    }

    thead tr:first-child th:first-child, tr:last-child th:last-child {
      background-color: #dedede;
    }

    td:first-child, td:last-child {
      background-color: #efefef;
    }

    td:first-child, th:first-child {
      position: sticky;
      left: 0;
      z-index: 1;
    }

    td:last-child, th:last-child {
      position: sticky;
      right: 0;
      z-index: 1;
    }
  }

  .image {
    // Combine with auto-width
    max-height: 100%;
    width: auto;
  }
</style>
