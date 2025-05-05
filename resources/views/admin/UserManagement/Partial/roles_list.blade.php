<script>
    document.addEventListener('DOMContentLoaded', function() {
        const moreText = document.getElementById('more-text');
        const permissionsList = document.getElementById('permissions-list');
        const permissionItems = permissionsList.querySelectorAll('.permission-item');

        // Check if there are more than 3 permissions
        const hiddenPermissions = permissionsList.querySelectorAll('.d-more');

        if (hiddenPermissions.length > 0) {
            // Show the "and X more..." text
            moreText.style.display = 'block';

            // Add click event to show more permissions
            moreText.addEventListener('click', function() {
                hiddenPermissions.forEach(function(item) {
                    item.classList.remove('d-none');
                });
                // Hide the "and X more..." text after clicking
                moreText.style.display = 'none';
            });
        }
    });
</script>
