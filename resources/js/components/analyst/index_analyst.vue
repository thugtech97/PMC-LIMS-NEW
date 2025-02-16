<template>
  <div class="container-fluid pd-x-0">
    <div
      class="
        d-sm-flex
        align-items-center
        justify-content-between
        mg-b-20 mg-lg-b-25 mg-xl-b-30
      "
    >
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item" aria-current="page">LIMS</li>
            <li class="breadcrumb-item" aria-current="page">Analyst</li>
            <li class="breadcrumb-item active" aria-current="page">
              Dashboard
            </li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Home/Dashboard - Analyst</h4>
      </div>
    </div>

    <div class="row row-sm">
      <!-- Start Pages -->

      <div class="col-md-12">
        <Toolbar class="mb-4 table-light">
          <template #start>
            <Button
              label="Export"
              icon="pi pi-upload"
              class="p-button-help p-button-sm mr-2"
              @click="exportCSV($event)"
            />
            <Button
              label="Generate Analytical Result"
              icon="pi pi-upload"
              class="p-button-success p-button-sm mr-2"
              @click="showDialog('Generate Analytical Result')"
            />
            <Button
              label="Generate Certificate of Analysis"
              icon="pi pi-upload"
              class="p-button-success p-button-sm mr-2"
              @click="showDialog('Generate Certificate of Analysis')"
            />
          </template>
          <template #end>
            <div class="search-form mg-r-10">
              <input
                name="search"
                type="search"
                id="search"
                class="form-control"
                placeholder="Search"
                v-model="filters['global'].value"
              />
              <button class="btn filter" id="btnSearch">
                <i data-feather="search"></i>
              </button>
            </div>
          </template>
        </Toolbar>
        <div class="table-list mg-b-10">
          <div class="table-responsive-lg">
            <DataTable
              ref="dt"
              :value="worksheets"
              :paginator="true"
              :rows="10"
              stripedRows
              removableSort
              paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
              :rowsPerPageOptions="[10, 20, 50]"
              responsiveLayout="scroll"
              :loading="loading1"
              currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
              v-model:filters="filters"
              filterDisplay="menu"
              :globalFilterFields="[
                'labbatch',
                'dateshift',
                'timeshift',
                'fusionfurno',
                'fusiontimefrom',
                'fusiontimeto',
                'fusion',
                'cupellationfurno',
                'cupellationtimefrom',
                'cupellationtimeto',
                'cupellation',
                'temperature',
                'moldused',
                'fireassayer',
              ]"
              v-model:selection="selectedTrans"
              :selectAll="selectAll"
              @select-all-change="onSelectAllChange"
              @row-select="onRowSelect"
              @row-unselect="onRowUnselect"
            >
              <template #empty> No record found. </template>
              <template #loading> Loading data. Please wait. </template>
              <Column field="id" hidden="true"></Column>
              <Column
                field="labbatch"
                header="Lab Batch"
                :sortable="true"
                style="min-width: 11rem"
              ></Column>
              <Column
                field="dateshift"
                header="Date and Time Shift Assayed"
                :sortable="true"
                style="min-width: 13rem"
              >
                <template #body="slotProps">
                  <span>{{
                    slotProps.data.dateshift +
                    " " +
                    slotProps.data.timeshift.replace(":00.0000000", "")
                  }}</span>
                </template></Column
              >
              <Column
                field="fusion_furnace"
                header="Fusion Furnace No. and Time"
                :sortable="true"
                style="min-width: 13rem"
              ></Column>
              <Column
                field="cupellation_furnace"
                header="Cupellation Furnace No. and Time"
                :sortable="true"
                style="min-width: 13rem"
              ></Column>
              <Column
                field="temperature"
                header="Temperature"
                :sortable="true"
              ></Column>
              <Column field="fusion" header="Fusion" :sortable="true"></Column>
              <Column
                field="cupellation"
                header="Cupellation"
                :sortable="true"
              ></Column>

              <Column
                field="moldused"
                header="Mold Used"
                :sortable="true"
              ></Column>
              <Column
                field="fireassayer"
                header="Fire Assayer"
                :sortable="true"
                style="min-width: 13rem"
              ></Column>
              <Column field="status" header="Status" :sortable="true">
                <template #body="slotProps">
                  <span
                    v-if="slotProps.data.isPosted == 1"
                    class="badge badge-danger tx-uppercase"
                    >Posted</span
                  >
                  <span
                    v-else-if="slotProps.data.isAnalyzed == 1"
                    class="badge badge-info tx-uppercase"
                    >Saved</span
                  >
                  <span
                    v-else-if="slotProps.data.isApproved == 1"
                    class="badge badge-success tx-uppercase"
                    >Approved</span
                  >
                  <span v-else>Pending</span>
                </template>
              </Column>
              <Column field="transType"></Column>
              <Column
                :exportable="false"
                style="min-width: 13rem"
                header="Actions"
              >
                <template #body="slotProps">
                  <Button
                    v-bind:title="viewMsg"
                    icon="pi pi-eye"
                    class="p-button-rounded p-button-success mr-2"
                    @click="viewWorksheet(slotProps)"
                  />
                  <Button
                    v-bind:title="editMsg"
                    icon="pi pi-pencil"
                    class="p-button-rounded p-button-success mr-2"
                    @click="editWorksheet(slotProps)"
                    :disabled="slotProps.data.isApproved == 0 || slotProps.data.isPosted == 1"
                  />
                  <Button
                    v-bind:title="printMsg"
                    icon="pi pi-print"
                    class="p-button-rounded p-button-info mr-2"
                    @click="printCertificate(slotProps)"
                    :disabled="slotProps.data.isAnalyzed == 0"
                  />
                </template>
              </Column>
            </DataTable>
          </div>
        </div>
      </div>
      <loading-component :visibility="loader"/>
      <!-- End Pages -->
    </div>
    <div class="cms-footer mg-t-50">
      <hr />
      <p class="tx-gray-500 tx-10">
        Admin Portal v1.0 • Developed by WebFocus Solutions, Inc. 2022
      </p>
    </div>
  </div>

  <toast
    :breakpoints="{ '920px': { width: '100%', right: '0', left: '0' } }"
  ></toast>
  <DynamicDialog />
  <ConfirmDialog></ConfirmDialog>
</template>
<script>
import { FilterMatchMode, FilterOperator } from "primevue/api";
import reportparam from "../../components/reportparam/analyticalresult";

export default {
  data() {
    return {
      loader: true,
      worksheets: [],
      filters: null,
      viewMsg: "View Worksheet",
      editMsg: "Edit Worksheet",
      deleteMsg: "Delete Worksheet",
      printMsg: "Export Analysis",
      transIds: null,
      isDisabled: false,
      form: {
        reqfrom: "index_analyst",
      }
    };
  },
  created() {
    this.fetchRecord();
    this.initFilters();
  },
  methods: {
    async fetchRecord() {
      const res = await this.callApiwParam(
        "post",
        "/assayer/getWorksheet",
        this.form
      );
      this.worksheets = res.data;
      this.loader = false
    },
    initFilters() {
      this.filters = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS },
      };
    },
    clearFilter() {
      this.filters["global"].value = null;
    },

    viewWorksheet(data) {
      let src = data.data.id,
        alt = data.data.id;
      window.location.href = this.$env_Url + "/analyst/view/" + alt;
    },
    exportCSV() {
      this.$refs.dt.exportCSV();
    },
    editWorksheet(data) {
      let src = data.data.id,
        alt = data.data.id;
      window.location.href = this.$env_Url + "/analyst/edit/" + alt;
    },
    printCertificate(data){
      var reportType = data.data.transType === "Carbon" ? "Generate Certificate of Analysis" : "Generate Analytical Result"
      //alert(data.data.transType)
      this.showDialog(reportType, data.data.labbatch, data.data.transType)
    },
    generateAnaReport(){
      window.location.href = this.$env_Url + "/analyst/AnalyticalResult";
      this.showDialog()
    },
    showDialog(ReportType, labbatch = "", transType = "") {
      const dialogRef = this.$dialog.open(reportparam, {
        props: {
          header: ReportType,
          style: {
            width: "50vw",
          },
          breakpoints: {
            "960px": "75vw",
            "640px": "90vw",
          },
          modal: true,
        },
        data: {
          reportType: ReportType,
          labbatch: labbatch,
          transType: transType,
        },
        onClose: (options) => {
        },
      });
    },
  },
};
</script>