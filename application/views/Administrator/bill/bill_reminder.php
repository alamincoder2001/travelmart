<div id="sms">
    <div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
        <div class="col-md-12">
            <form class="form-inline" id="searchForm" @submit.prevent="getReminderList">
                <div class="form-group">
                    <label>Date</label>
					<input type="date" class="form-control" v-model="reminderDate">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
            </form>
        </div>
    </div>
    <div class="row" style="padding-top: 10px;">
        <div class="col-md-5">
            <form v-on:submit.prevent="sendSms">
                <div class="form-group">
                    <label for="smsText">SMS Text</label>
                    <textarea class="form-control" id="smsText" v-model="smsText" v-on:input="checkSmsLength" style="height:100px;"></textarea>
                    <p style="display:none" v-bind:style="{display: smsText.length > 0 ? '' : 'none'}">{{ smsText.length }} | {{ smsLength - smsText.length }} Remains | Max: {{ smsLength }} characters</p>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-xs pull-right" v-bind:style="{display: onProgress ? 'none' : ''}"> <i class="fa fa-send"></i> Send </button>
                    <button type="button" class="btn btn-primary btn-xs pull-right" disabled style="display:none" v-bind:style="{display: onProgress ? '' : 'none'}"> Please Wait .. </button>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Select All &nbsp; <input type="checkbox" v-on:click="selectAll"></th>
                            <th>Reminder Date</th>
                            <th>Client Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Airline</th>
                            <th>Route</th>
                            <th>Flight Date</th>
                        </tr>
                    </thead>
                    <tbody style="display:none" v-bind:style="{display: reminders.length > 0 ? '' : 'none'}">
                        <tr v-for="customer in reminders">
                            <td><input type="checkbox" v-bind:value="customer.phone" v-model="reminder" v-if="customer.phone.match(regexMobile)"></td>
                            <td>{{ customer.reminder_date }}</td>
                            <td>{{ customer.name }}</td>
                            <td><span class="label label-md arrowed" v-bind:class="[customer.phone.match(regexMobile) ? 'label-info' : 'label-danger']">{{ customer.phone }}</span></td>
                            <td>{{ customer.address }}</td>
                            <td>{{ customer.airline }}</td>
                            <td>{{ customer.route }}</td>
                            <td>{{ customer.flight_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
    new Vue({
        el:'#sms',
        data(){
            return {
                reminderDate: moment().format('YYYY-MM-DD'),
                reminders:[],
                reminder: [],
                smsText: '',
                smsLength: 306,
                onProgress: false,
                regexMobile: /^01[13-9][\d]{8}$/
            }
        },
        created(){
            this.getReminderList();
        },
        methods:{
            getReminderList() {
                axios.post('/get-reminder-list', {reminderDate: this.reminderDate}).then(res => {
                    this.reminders = res.data.map(bill => {
                        bill.phone = bill.phone.trim();
                        return bill;
                    });
                })
            },
    
            selectAll(){
                let checked = event.target.checked;
                if(checked){
                    this.reminder = [...new Set(this.reminders.map(v => v.phone))].filter(mobile => mobile.match(this.regexMobile));
                } else {
                    this.reminder = [];
                }
            },
            checkSmsLength(){
                if(this.smsText.length > this.smsLength){
                    this.smsText = this.smsText.substring(0, this.smsLength);
                }
            },
            sendSms(){
                if(this.reminder.length == 0){
                    alert('Select Client');
                    return;
                }

                if(this.smsText.length == 0){
                    alert('Enter sms text');
                    return;
                }

                let data = {
                    smsText: this.smsText,
                    numbers: this.reminder
                }

                this.onProgress = true;
                axios.post('/send_bulk_sms', data).then(res => {
                    let r = res.data;
                    alert(r.message);
                    this.onProgress = false;
                })
            }
        }
    })
</script>