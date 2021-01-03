<template>
	<div>
		<v-app v-if="orders.length > 0" id="inspire">
			<v-data-table
				:headers="tableHeaders"
				:items="orders"
				item-key="id"
				single-expand
				hide-default-footer
				@click:row="(item, slot) => slot.expand(!slot.isExpanded)"
			>


				<template v-slot:expanded-item="{ headers, item }">
					<td :colspan="headers.length" class="container">
						<div class="row">
							<div class="col-xl-3">
								<strong>Customer</strong>: <p>{{ item.customer.name }}</p>
							</div>
							<div class="col-md-2">
								<strong>Phone Number</strong>: <p>{{ item.customer.customer.phone }}</p>
							</div>
							<div class="col-md-2">
								<strong>Notes</strong>: <p v-if="item.notes">{{ item.notes }}</p><p v-else>No notes have been attached</p>
							</div>
							<div class="col-xl-1">
								<button type="button" class="btn btn-success pb-1 pt-1 mt-3 mb-1" @click="deliver(item.id)">Deliver</button>
							</div>

						</div>
					</td>
				</template>

			</v-data-table>
		</v-app>
		<div v-else class="d-flex justify-content-center mt-5">
			<h2>There are no orders at the moment!</h2>
		</div>
	</div>
</template>

<script>
export default {
	name: "OrdersReadyForDelivery",
	props: ["orders"],
	data: function (){
		return {
			title: "Orders Ready",
			tableHeaders: [
				{
					text: 'Order number',
					align: 'start',
					sortable: false,
					value: 'id',
				},
				{ text: 'Ready for (minutes)', value: 'time_elapsed_since_status' },
				{ text: 'Prepared in (seconds)', value: 'preparation_time' },
				{ text: 'Address', value: 'customer.customer.address' }
			],
		}
	},
	methods:{
		deliver: function (order_id){
			this.$emit('order-selected', order_id)
		}
	},
	mounted() {
	}
}
</script>

<style scoped>

</style>
