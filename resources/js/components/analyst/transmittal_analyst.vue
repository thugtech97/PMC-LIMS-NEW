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
                Transmittal Dashboard
              </li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Home/Transmittal Dashboard - Analyst</h4>
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
              <div class="search-form mg-r-10" style="width: 200px">
              <Calendar
                id="icon"
                v-model="form.dateFrom"
                :showIcon="true"
                v-tooltip="'Date From'"
                pattern="dd/MM/yyyy"
                autocomplete="off"
              />
            </div>
            <div class="search-form mg-r-10" style="width: 200px">
              <Calendar
                id="icon2"
                v-model="form.dateTo"
                :showIcon="true"
                v-tooltip="'Date To'"
              />
            </div>
            <Button
              icon="pi pi-search"
              class="p-button-success p-button-sm mr-2"
              v-tooltip="'Search'"
              @click="fetchRecord()"
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
                :value="transmittals"
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
                  'transmittalno',
                  'date_time_submitted',
                  'email_address',
                  'purpose',
                  'date_needed',
                  'priority_status',
                  'source',
                  'statuses',
                ]"
              >
                <template #empty> No record found. </template>
                <template #loading> Loading data. Please wait. </template>
                <Column field="id" hidden="true"></Column>
                <Column
                  field="transmittalno"
                  header="Transmittal No"
                  :sortable="true"
                ></Column>
                <Column
                  field="datesubmitted"
                  header="Date Submitted"
                  :sortable="true"
                ></Column>
                <Column
                  field="timesubmitted"
                  header="Time Submitted"
                  :sortable="true"
                >
                  <template #body="slotProps">
                    <span>{{
                      slotProps.data.timesubmitted.replace(":00.0000000", "")
                    }}</span>
                  </template></Column
                >
                <Column
                  field="email_address"
                  header="Email Address"
                  :sortable="true"
                ></Column>
                <Column
                  field="purpose"
                  header="Purpose"
                  :sortable="true"
                ></Column>
                <Column
                  field="date_needed"
                  header="Date Needed"
                  :sortable="true"
                ></Column>
  
                <Column
                  field="priority"
                  header="Priority"
                  :sortable="true"
                  :exportable="false"
                >
                  <template #body="slotProps">
                    <span
                      v-if="slotProps.data.priority == 'High'"
                      class="badge badge-danger tx-uppercase"
                      >High</span
                    >
                    <span
                      v-if="slotProps.data.priority == 'Medium'"
                      class="badge badge-warning tx-uppercase"
                      >Medium</span
                    >
                    <span
                      v-if="slotProps.data.priority == 'Low'"
                      class="badge badge-success tx-uppercase"
                      >Low</span
                    >
                  </template>
                </Column>
  
                <Column field="source" header="Source" :sortable="true"></Column>
                <Column field="status" header="Status" :sortable="true">
                  <template #body="slotProps">
                    <span
                      v-if="slotProps.data.isReceived == 1"
                      class="badge badge-danger tx-uppercase"
                      >Received</span
                    >
                    <span
                      v-else-if="slotProps.data.status == 'Approved'"
                      class="badge badge-success tx-uppercase"
                      >Approved</span
                    >
                    <span v-else>Pending</span>
                  </template>
                </Column>
  
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
                      @click="viewTransmittal(slotProps)"
                    />
                    <Button
                      v-bind:title="receiveMsg"
                      icon="pi pi-arrow-circle-down"
                      class="p-button-rounded p-button-success mr-2"
                      @click="receiveTransmittal(slotProps)"
                      :disabled="slotProps.data.isReceived == 1"
                    />
                    <!-- <Button
                      v-bind:title="editMsg"
                      icon="pi pi-pencil"
                      class="p-button-rounded p-button-success mr-2"
                      @click="editTransmittal(slotProps)"
                      :disabled="slotProps.data.isEditable == 0"
                    /> -->
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
    <ConfirmDialog></ConfirmDialog>
  </template>
  <script>
  import { FilterMatchMode, FilterOperator } from "primevue/api";
  export default {
    // props: ["deptofficers"],
    data() {
      return {
        loader: true,
        transmittals: [],
        dashboard: this.$env_Url + "analyst/dashboard",
        filters: null,
        viewMsg: "View Transmittal",
        editMsg: "Edit Transmittal",
        receiveMsg: "Receive Transmittal",
        statuses: ["Pending", "Approved", "Received"],
        form: {
          id: 0,
          dateFrom: new Date(),
          dateTo: new Date(),
        },
      };
    },
    created() {
      const today = new Date();
      this.form.dateFrom = new Date(today.getFullYear(),today.getMonth(),1);
      this.form.dateTo =  new Date(today.getFullYear(),today.getMonth() + 1,0);
      this.fetchRecord();
      this.initFilters();
    },
    methods: {
      async fetchRecord() {
        const res = await this.callApiwParam(
          "post",
          "/analyst/getTransmittal",
          this.form
        );  
        this.transmittals = res.data;
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
  
      viewTransmittal(data) {
        let src = data.data.id,
          alt = data.data.id;
        window.location.href =
          this.$env_Url + "/analyst/view-transmittal/" + alt;
      },
      receiveTransmittal(data) {
        let src = data.data.id,
          alt = data.data.id;
        window.location.href =
          this.$env_Url + "/analyst/receive-transmittal/" + alt;
      },
  
      editTransmittal(data) {
        let src = data.data.id,
          alt = data.data.id;
        window.location.href =
          this.$env_Url + "/analyst/edit-transmittal/" + alt;
      },
  
      exportCSV() {
        this.$refs.dt.exportCSV();
      },
    },
  };
  </script>