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
            <li class="breadcrumb-item" aria-current="page">
              <a :href="dashboard">LIMS</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
              <a :href="dashboard">Officer</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Post Worksheet
            </li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Post Worksheet - Officer</h4>
      </div>
    </div>
    <div v-if="errors_exist" class="alert alert-danger" role="alert">
      Whoops! Something didn't work.
      <ul>
        <div v-for="error in errors" :key="error.id">
          <li>{{ error[0] }}</li>
        </div>
      </ul>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="border p-2 p-lg-3 rounded mb-3">
          <div class="row row-sm">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="date-shift-assayed">Date Shift and Assayed</label>
                <input
                  type="text"
                  class="form-control"
                  id="date-shift-assayed"
                  name="date-shift-assayed"
                  pattern="\d{2}\/\d{2}\/\d{4}"
                  placeholder="mm/dd/yyyy"
                  v-model="form.dateshift"
                  disabled="true"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="time-shift-assayed">Time</label>
                <input
                  type="time"
                  class="form-control"
                  id="time-shift-assayed"
                  name="time-shift-assayed"
                  v-model="form.timeshift"
                  disabled="true"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="border p-2 p-lg-3 rounded mb-3">
          <div class="row row-sm">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="fusion-furnace-no">Fusion Furnace No.</label>
                <input
                  type="text"
                  class="form-control"
                  id="fusion-furnace-no"
                  name="fusion-furnace-no"
                  placeholder="#1"
                  v-model="form.fusionfurno"
                  disabled="true"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="time-from1">Time From</label>
                <input
                  type="time"
                  class="form-control"
                  id="time-from1"
                  name="time-from1"
                  v-model="form.fusiontimefrom"
                  disabled="true"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="time-to1">To</label>
                <input
                  type="time"
                  class="form-control"
                  id="time-to1"
                  name="time-to1"
                  v-model="form.fusiontimeto"
                  disabled="true"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="border p-2 p-lg-3 rounded mb-3">
          <div class="row row-sm">
            <div class="col-lg-12">
              <div class="form-group">
                <label for="cupellation-furnace-no"
                  >cupellation Furnace No.</label
                >
                <input
                  type="text"
                  class="form-control"
                  id="cupellation-furnace-no"
                  name="cupellation-furnace-no"
                  placeholder="#1"
                  v-model="form.cupellationfurno"
                  disabled="true"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="time-from2">Time From</label>
                <input
                  type="time"
                  class="form-control"
                  id="time-from2"
                  name="time-from2"
                  v-model="form.cupellationtimefrom"
                  disabled="true"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="time-to2">To</label>
                <input
                  type="time"
                  class="form-control"
                  id="time-to2"
                  name="time-to2"
                  v-model="form.cupellationtimeto"
                  disabled="true"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row row-sm">
          <div class="col-lg-6">
            <div class="form-group">
              <label for="lab-batch">Lab Batch</label>
              <input
                type="text"
                class="form-control"
                id="lab-batch"
                name="lab-batch"
                placeholder="MM-00381"
                v-model="form.labbatch"
                disabled="true"
              />
            </div>
          </div>
          <div class="col-lg-6">
            <div class="form-group">
              <label for="type">Type</label>
              <input
                type="text"
                class="form-control"
                id="transType"
                name="transType"
                v-model="form.transType"
                disabled="true"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="form-group">
          <label for="temperature">Temperature </label>
          <input
            type="text"
            class="form-control"
            id="temperature"
            name="temperature"
            placeholder="Display/Pyrometer"
            v-model="form.temperature"
            disabled="true"
          />
        </div>

        <div class="form-group">
          <label for="fusion">Fusion</label>
          <input
            type="text"
            class="form-control"
            id="fusion"
            name="fusion"
            placeholder="1050/1098"
            v-model="form.fusion"
            disabled="true"
          />
        </div>

        <div class="form-group">
          <label for="cupellation">Cupellation</label>
          <input
            type="text"
            class="form-control"
            id="cupellation"
            name="cupellation"
            placeholder="950/993"
            v-model="form.cupellation"
            disabled="true"
          />
        </div>

        <div class="form-group">
          <label for="mold-used">Mold Used</label>
          <input
            type="text"
            class="form-control"
            id="mold-used"
            name="mold-used"
            placeholder="M1M5"
            v-model="form.moldused"
            disabled="true"
          />
        </div>

        <div class="form-group">
          <label for="fire-assayer">Fire Assayer</label>
          <select
            class="custom-select tx-base"
            id="fire-assayer"
            name="fire-assayer"
            v-model="form.fireassayer"
            disabled="true"
          >
          <option v-for="fireassayer in fireassayers" :key="fireassayer.id" :value="fireassayer.name">{{fireassayer.name}}</option>
         </select>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="border p-2 p-lg-3 rounded mb-3">
          <div class="row row-sm">
            <div class="col-lg-6">
              <div class="form-group">
                <label for="date-shift-weighed1">Date and Shift Weighed</label>
                <input
                  type="text"
                  class="form-control"
                  id="date-shift-weighed1"
                  name="date-shift-weighed1"
                  pattern="\d{2}\/\d{2}\/\d{4}"
                  placeholder="mm/dd/yyyy"
                  v-model="form.dateweighed"
                  disabled="true"
                />
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label for="date-shift-weighed2">&nbsp;</label>
                <input
                  type="text"
                  class="form-control"
                  id="date-shift-weighed2"
                  name="date-shift-weighed2"
                  placeholder="S2"
                  v-model="this.form.shiftweighed"
                  disabled="true"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label for="microbalance-no-check-weights"
            >Microbalance No. and Check Weights</label
          >
          <input
            type="text"
            class="form-control"
            id="microbalance-no-check-weights"
            name="microbalance-no-check-weights"
            placeholder="#1 - 0.00009, 5000, 9111"
            v-model="this.form.micnocheckweights"
            disabled="true"
          />
        </div>

        <div class="form-group">
          <label for="measured-by">Measured By</label>
          <select
            class="custom-select tx-base"
            id="measured-by"
            name="measured-by"
            v-model="this.form.measuredby"
            disabled="true"
          >
          <option
              v-for="analyst in analysts"
              :key="analyst.id"
              :value="analyst.name"
            >
              {{ analyst.name }}
            </option>
          </select>
        </div>

        <div class="form-group">
          <label for="analyzed-by">Analyzed By</label>
          <select
            class="custom-select tx-base"
            id="analyzed-by"
            name="analyzed-by"
            v-model="this.form.analyzedby"
            disabled="true"
          >
          <option
              v-for="analyst in analysts"
              :key="analyst.id"
              :value="analyst.name"
            >
              {{ analyst.name }}
            </option>
          </select>
        </div>
      </div>
      <div class="col-lg-12">
        <hr class="mg-t-10 mg-b-30" />
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12">
        <div class="table-responsive-lg">
          <DataTable
            ref="dt"
            :value="items"
            :paginator="true"
            :rows="10"
            stripedRows
            paginatorTemplate="CurrentPageReport FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            :rowsPerPageOptions="[10, 20, 50]"
            responsiveLayout="scroll"
            :loading="loading"
            currentPageReportTemplate="Showing {first} to {last} of {totalRecords}"
            v-model:filters="filters"
            filterDisplay="menu"
            rowIndexVar
          >
            <template #empty> No record found. </template>
            <template #loading> Loading data. Please wait. </template>

            <Column header="Sample No.">
              <template #body="slotProps">
                {{ slotProps.index + 1 }}
              </template></Column
            >
            <Column field="id" hidden="true"></Column>
            <Column field="sampleno" header="Sample Code"></Column>
            <Column
              field="source"
              header="Source"
              style="min-width: 8rem"
            ></Column>
            <Column field="samplewtvolume" header="Sample Wt.(Grams)"></Column>
            <Column field="crusibleused" header="Crusible Used"></Column>
            <Column field="transmittalno" header="Transmittal No."></Column>
            <Column field="fluxg" header="Flux (Grams)"></Column>
            <Column field="flourg" header="Flour (Grams)"></Column>
            <Column field="niterg" header="Niter (Grams)"></Column>
            <Column field="leadg" header="Lead (Grams)"></Column>
            <Column field="silicang" header="Silican (Grams)"></Column>
            <Column field="auprillmg" header="Au, Prill(Mg)"></Column>
            <Column field="augradegpt" header="Au, Grade(Gpt)"></Column>
            <Column field="assreadingppm" header="ASS Reading, ppm"></Column>
            <Column field="agdoremg" header="Ag, Dore(Mg)"></Column>
            <Column field="initialaggpt" header="Initial Ag (Gpt)"></Column>
            <Column
              field="crusibleclearance"
              header="Crusible Clearance"
            ></Column>
            <Column field="inquartmg" header="For Inquart (Mg)"></Column>
            <Column field="methodremarks" header="Remarks"></Column>
          </DataTable>
        </div>
      </div>
    </div>
    <!-- row -->
    <hr class="mg-t-30 mg-b-30" />

    <div class="row flex-column-reverse flex-lg-row">
      <div class="col-lg-6">
        <a :href="dashboard" class="btn btn-white tx-13 btn-uppercase"
          ><i data-feather="arrow-left" class="mg-r-5"></i> Back to Dashboard</a
        >
      </div>
      <div class="col-lg-6 d-flex justify-content-start justify-content-lg-end">
        <button
          type="submit"
          class="btn btn-danger tx-13 btn-uppercase mr-2 mb-2 ml-lg-1 mr-lg-0"
          @click.prevent="saveWorksheet"
        >
          <i data-feather="check-circle" class="mg-r-5"></i> Post
        </button>
      </div>
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
import item from "../../components/item/item";
import { h } from "vue";
import Button from "primevue/button";
export default {
  props: ["worksheet"],
  data() {
    return {
      dashboard: this.$env_Url + "/officer/dashboard",
      loading: true,
      items: [],
      errors_exist: false,
      errors: {},
      isApproved: this.worksheet.isApproved,
      fireassayers : [],
      analysts: [],
      form: {
        id: this.worksheet.id,
        labbatch: this.worksheet.labbatch,
        dateshift: this.worksheet.dateshift,
        timeshift: this.worksheet.timeshift,
        fusionfurno: this.worksheet.fusionfurno,
        fusiontimefrom: this.worksheet.fusiontimefrom,
        fusiontimeto: this.worksheet.fusiontimeto,
        fusion: this.worksheet.fusion,
        cupellationfurno: this.worksheet.cupellationfurno,
        cupellationtimefrom: this.worksheet.cupellationtimefrom,
        cupellationtimeto: this.worksheet.cupellationtimeto,
        cupellation: this.worksheet.cupellation,
        temperature: this.worksheet.temperature,
        moldused: this.worksheet.moldused,
        fireassayer: this.worksheet.fireassayer,
        ids: this.transids,
        transType: this.worksheet.transType,
        dateweighed: this.worksheet.dateweighed,
        shiftweighed: this.worksheet.shiftweighed,
        micnocheckweights: this.worksheet.micnocheckweights,
        measuredby: this.worksheet.measuredby,
        analyzedby: this.worksheet.analyzedby,
        isPosted : this.worksheet.isPosted
      },
    };
  },
  created() {
    this.fetchFireAssayer();
    this.fetchAnalyst();
    this.fetchItems();
    this.loading = false;
  },
  mounted() {
    this.form.timeshift = this.worksheet.timeshift.replace(":00.0000000", "");
    this.form.fusiontimefrom = this.worksheet.fusiontimefrom.replace(
      ":00.0000000",
      ""
    );
    this.form.fusiontimeto = this.worksheet.fusiontimeto.replace(
      ":00.0000000",
      ""
    );
    this.form.cupellationtimefrom = this.worksheet.cupellationtimefrom.replace(
      ":00.0000000",
      ""
    );
    this.form.cupellationtimeto = this.worksheet.cupellationtimeto.replace(
      ":00.0000000",
      ""
    );
    // document.getElementById("date-shift-weighed1").value = this.worksheet.dateweighed;
  },
  methods: {
    async fetchItems() {
      const res = await this.callApiwParam(
        "post",
        "/transItem/getWorksheetItems",
        this.form
      );
      this.items = res.data;
    },
    async saveWorksheet() {
      const res = await this.submit("post", "/officer/update", this.form, {
        headers: {
          "Content-Type":
            "multipart/form-data; charset=utf-8; boundary=" +
            Math.random().toString().substr(2),
        },
      });
      if (res.status === 200) {
        window.location.href = this.$env_Url + "/officer/dashboard";
      } else {
        this.errors_exist = true;
        this.errors = res.data.errors;
      }
    },
    async fetchFireAssayer() {
      const res = await this.getDataFromDB("get", "/fireassayers/getFireAssayerActive");

      this.fireassayers = res.data;
    },
    async fetchAnalyst() {
      const res = await this.getDataFromDB(
        "get",
        "/qaanalysts/getAnalystActive"
      );

      this.analysts = res.data;
    },
  },
};
</script>
  