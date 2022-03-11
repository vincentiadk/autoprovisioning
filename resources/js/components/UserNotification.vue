<template>
  <div class="list-group">
    <a
      href="#"
      class="list-group-item list-group-item-action active"
      v-for="notification in notifications"
    >
      <div class="notification-info">
        <div class="notification-list-user-img">
          <img
            src="/assets/images/avatar-2.jpg"
            alt=""
            class="user-avatar-md rounded-circle"
          />
        </div>
        <div class="notification-list-user-block">
          <span class="notification-list-user-name">
            {{ notification.user.name }}
          </span>
          {{ notification.message }}
          <div class="notification-date">{{ notification.created_at }}</div>
        </div>
      </div>
    </a>
  </div>
</template>

<script>
export default {
  props: ["notifications"],

  methods: {
    fetchNotifications() {
      let currentObj = this;
      axios.get("/notifications").then((response) => {
        currentObj.$parent.notifications = response.data;
      });
    },
  },
  created() {
    this.fetchNotifications();
    console.log("User notification called");
  },
};
</script>