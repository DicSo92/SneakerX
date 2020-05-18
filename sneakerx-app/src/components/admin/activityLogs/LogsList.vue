<template>
  <div class="full-width">
    <q-table
      title="Treats"
      :data="activityLogs"
      :columns="columns"
      :visible-columns="visibleColumns"
      row-key="id"
      selection="single"
      :selected.sync="selected"
      :loading="loading"
      class="BrandTable"
    >

      <template v-slot:top>
        <q-icon name="local_offer" size="lg"/>

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
          <q-th auto-width></q-th>
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
        <q-tr :props="props" @click="props.expand = !props.expand" class="cursor-pointer">
          <q-td>
            <q-checkbox v-model="props.selected"/>
          </q-td>
          <q-td key="id" :props="props" auto-width>
            {{ props.row.id }} #
          </q-td>
          <q-td key="log_name" :props="props">
            <q-chip :color="colorByLogName(props.row.log_name)"
                    text-color="white" size="md" square
                    :label="props.row.log_name" />
          </q-td>
          <q-td key="description" :props="props">
            <q-chip :color="colorByDescription(props.row.description)"
                    text-color="white" size="md"
                    :label="props.row.description" />
          </q-td>
          <q-td key="subject_id" :props="props">
            <div>{{props.row.subject_id}}</div>
          </q-td>
          <q-td key="subject_type" :props="props">
            <div>{{props.row.subject_type}}</div>
          </q-td>
          <q-td key="created_at" :props="props" class="text-caption text-grey-7">
            {{ cFormatDate(props.row.created_at) }}
          </q-td>
          <q-td key="causer_id" :props="props" auto-width>
            <div class="text-pre-wrap text-bold">{{ props.row.causer_id ? props.row.causer_id : 'Unknown' }}</div>
          </q-td>
        </q-tr>

        <q-tr v-show="props.expand" :props="props">
          <q-td colspan="100%">
            <div class="row no-wrap" v-if="props.row.properties.old">
              <div class="col-6 column items-start">
                <p class="text-bold no-margin">Old data : </p>
                <div class="flex justify-center items-center" style="flex-grow: 3;">
                  <div class="" v-for="(property, index) in props.row.properties.old">
                    <span class="text-bold">{{index}} : </span>
                    {{property ? property : 'NULL'}}
                  </div>
                </div>
              </div>
              <q-separator vertical inset class="q-mx-md"/>
              <div class="col-auto column items-start">
                <p class="text-bold no-margin">New data : </p>
                <div class="flex justify-center items-center" style="flex-grow: 3;">
                  <div class="" v-for="(property, index) in props.row.properties.attributes">
                    <span class="text-bold">{{index}} : </span>
                    {{property ? property : 'NULL'}}
                  </div>
                </div>
              </div>
            </div>
            <div class="flex q-gutter-md" v-else>
              <div class="" v-for="(property, index) in props.row.properties.attributes">
                <span class="text-bold">{{index}} : </span>
                {{property ? property : 'NULL'}}
              </div>
            </div>
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
    import {QSpinnerGears, date} from 'quasar'

    export default {
        name: "LogsList",
        data() {
            return {
                activityLogs: [],
                loading: true,
                search: '',

                pagination: {
                    sortBy: 'id',
                    descending: false,
                    // page: 2,
                    rowsPerPage: 15,
                    // rowsNumber: xx if getting data from a server
                },
                selected: [],
                visibleColumns: ['id', 'log_name', 'description', 'subject_id', 'subject_type', 'created_at', 'causer_id'],
                columns: [
                    {name: 'id', required: true, label: 'ID', field: row => row.id, align: 'left', sortable: true},
                    {name: 'log_name', align: 'left', label: 'Log Name', field: 'log_name', sortable: true},
                    {name: 'description', align: 'left', label: 'Description', field: 'description', sortable: true},
                    {name: 'subject_id', align: 'left', label: '# Subject', field: 'subject_id'},
                    {name: 'subject_type', align: 'left', label: 'Subject', field: 'subject_type', sortable: true},
                    {name: 'created_at', label: 'Created At', field: 'created_at', sortable: true},
                    {name: 'causer_id', required: true, label: '# User', field: 'causer_id', align: 'right', sortable: true},
                ],
            }
        },
        created() {
            this.getActivityLogs()
        },
        mounted() {
            bus.$on('refreshActivityLogs', () => {
                this.getActivityLogs()
            })
        },
        watch: {
            selected (val) {
                this.$emit('selectedChange', val)
            },
        },
        methods: {
            colorByLogName(logName) {
                if (logName === 'User') {
                    return 'amber-5'
                } else if (logName === 'Brand') {
                    return 'purple-5'
                } else if (logName === 'Order') {
                    return 'lime-5'
                }
            },
            colorByDescription(description) {
                if (description === 'created') {
                    return 'green-5'
                } else if (description === 'updated') {
                    return 'orange-5'
                } else if (description === 'deleted') {
                    return 'red-5'
                }
            },
            cFormatDate(Date) {
                return date.formatDate(Date, 'DD/MM/YY HH:mm')
            },
            getActivityLogs() {
                this.loading = true
                this.$axios.get('/api/admin/activityLog')
                    .then(response => {
                        console.log(response)
                        this.activityLogs = response.data
                        this.loading = false
                    })
                    .catch(error => {
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

  .BrandTable {
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
</style>
