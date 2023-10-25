<template>
  <div>
    <title-bar :title-stack="['Admin', 'View']"/>
    <hero-bar>
      FIles
      <router-link to="/ftp/new" class="button" slot="right">
        New Client
      </router-link>
    </hero-bar>
    <section class="section is-main-section">
      <card-component class="has-table has-mobile-sort-spaced" title="File List" icon="account-multiple">
        <!--        <card-toolbar>-->
        <!--          <button slot="right" type="button" class="button is-danger is-small has-checked-rows-number" @click="trashModal(null)" :disabled="!checkedRows.length">-->
        <!--            <b-icon icon="trash-can" custom-size="default"/>-->
        <!--            <span>Delete</span>-->
        <!--            <span v-show="!!checkedRows.length">({{ checkedRows.length }})</span>-->
        <!--          </button>-->
        <!--        </card-toolbar>-->

        <modal-box
          :is-active="isModalActive"
          :trash-object-name="trashSubject"
          @confirm="trashConfirm"
          @cancel="trashCancel"
        />

        <b-table
          :loading="isLoading"
          :paginated="paginated"
          :per-page="perPage"
          :striped="true"
          :hoverable="true"
          default-sort="name"
          class="scrollable-table"
          :data="Files">

          <b-table-column label="column1" field="name" sortable v-slot="props">
            {{ props.row.column1 }}
          </b-table-column>
          <b-table-column label="column2" field="name" sortable v-slot="props">
            {{ props.row.column2 }}
          </b-table-column>
          <b-table-column label="column3" field="name" sortable v-slot="props">
            {{ props.row.column3 }}
          </b-table-column>
          <b-table-column label="column4" field="name" sortable v-slot="props">
            {{ props.row.column4 }}
          </b-table-column>
          <b-table-column label="column5" field="name" sortable v-slot="props">
            {{ props.row.column5}}
          </b-table-column>
          <b-table-column label="column6" field="name" sortable v-slot="props">
            {{ props.row.column6}}
          </b-table-column>
          <b-table-column label="column7" field="name" sortable v-slot="props">
            {{ props.row.column7 }}
          </b-table-column>
          <b-table-column label="column8" field="name" sortable v-slot="props">
            {{ props.row.column8 }}
          </b-table-column>
          <b-table-column label="column9" field="name" sortable v-slot="props">
            {{ props.row.column9 }}
          </b-table-column>
          <b-table-column label="column10" field="name" sortable v-slot="props">
            {{ props.row.column10 }}
          </b-table-column>
          <b-table-column label="column11" field="name" sortable v-slot="props">
            {{ props.row.column11 }}
          </b-table-column>
          <b-table-column label="column12" field="name" sortable v-slot="props">
            {{ props.row.column12 }}
          </b-table-column>
          <b-table-column label="column13" field="name" sortable v-slot="props">
            {{ props.row.column13 }}
          </b-table-column>
          <b-table-column label="column14" field="name" sortable v-slot="props">
            {{ props.row.column14 }}
          </b-table-column>
          <b-table-column label="column15" field="name" sortable v-slot="props">
            {{ props.row.column15 }}
          </b-table-column>
          <b-table-column label="column16" field="name" sortable v-slot="props">
            {{ props.row.column16 }}
          </b-table-column>
          <b-table-column label="column17" field="name" sortable v-slot="props">
            {{ props.row.column17 }}
          </b-table-column>
          <b-table-column label="column18" field="name" sortable v-slot="props">
            {{ props.row.column18 }}
          </b-table-column>
          <b-table-column label="column19" field="name" sortable v-slot="props">
            {{ props.row.column19 }}
          </b-table-column>

          <b-table-column custom-key="actions" class="is-actions-cell" v-slot="props">
            <div class="buttons is-right">
              <router-link :to="{name:'ftp.view', params: {id: props.row.id}}" class="button is-small is-primary">
                <b-icon icon="account-edit" size="is-small"/>
              </router-link>
              <button class="button is-small is-danger" type="button" @click.prevent="trashModal(props.row)">
                <b-icon icon="trash-can" size="is-small"/>
              </button>
            </div>
          </b-table-column>

          <section class="section" slot="empty">
            <div class="content has-text-grey has-text-centered">
              <template v-if="isLoading">
                <p>
                  <b-icon icon="dots-horizontal" size="is-large"/>
                </p>
                <p>Fetching data...</p>
              </template>
              <template v-else>
                <p>
                  <b-icon icon="emoticon-sad" size="is-large"/>
                </p>
                <p>Nothing's here&hellip;</p>
              </template>
            </div>
          </section>
        </b-table>
      </card-component>
    </section>
  </div>

</template>

<script>
import map from 'lodash/map'
import CardComponent from '@/components/CardComponent'
import ModalBox from '@/components/ModalBox'
import TitleBar from '@/components/TitleBar'
import HeroBar from '@/components/HeroBar'
import CardToolbar from '@/components/CardToolbar'

export default {
  name: "FTPIndex",
  components: {CardToolbar, HeroBar, TitleBar, ModalBox, CardComponent},
  data () {
    return {
      isModalActive: false,
      trashObject: null,
      Files: [],
      isLoading: false,
      paginated: false,
      perPage: 10,
      checkedRows: []
    }
  },
  computed: {
    trashSubject () {
      if (this.trashObject) {
        return this.trashObject.name
      }

      if (this.checkedRows.length) {
        return `${this.checkedRows.length} entries`
      }

      return null
    }
  },
  created () {
    this.getData()
  },
  methods: {
    getData () {
      this.isLoading = true
      axios
        .post('api/showExcelFile',{id:this.$route.params.id})
        .then(r => {
          console.log(r)
          this.Files = r.data.data
          this.isLoading = false
        })
        .catch( err => {
          this.isLoading = false
          this.$buefy.toast.open({
            message: `Error: ${err.message}`,
            type: 'is-danger',
            queue: false
          })
        })
    },
    trashModal (trashObject = null) {
      if (trashObject || this.checkedRows.length) {
        this.trashObject = trashObject
        this.isModalActive = true
      }
    },
    trashConfirm () {
      let url
      let method
      let data = null

      this.isModalActive = false

      if (this.trashObject) {
        method = 'delete'
        url = `/clients/${this.trashObject.id}/destroy`
      } else if (this.checkedRows.length) {
        method = 'post'
        url = '/clients/destroy'
        data = {
          ids: map(this.checkedRows, row => row.id)
        }
      }

      axios({
        method,
        url,
        data
      }).then( r => {
        this.getData()

        this.trashObject = null
        this.checkedRows = []

        this.$buefy.snackbar.open({
          message: `Deleted`,
          queue: false
        })
      }).catch( err => {
        this.$buefy.toast.open({
          message: `Error: ${err.message}`,
          type: 'is-danger',
          queue: false
        })
      })
    },
    trashCancel () {
      this.isModalActive = false
    }
  }
}
</script>

<style>
.card.has-table .b-table{
  overflow-x: scroll;
  max-width: 80vw;
}
</style>
