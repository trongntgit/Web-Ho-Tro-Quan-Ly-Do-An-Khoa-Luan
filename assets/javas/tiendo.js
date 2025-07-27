document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar visibility
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    sidebarToggle.addEventListener('click', function() {
      sidebar.classList.toggle('hidden');
    });

    // Handle notification click
    const notificationIcon = document.querySelector('.fa-bell');
    notificationIcon.addEventListener('click', function() {
      alert('You have new notifications!');
    });
  });

  alert("heheheheh")