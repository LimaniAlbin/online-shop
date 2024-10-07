export function getCurrentUserRole() {
    // Retrieve the user's role from the local storage
    const role = localStorage.getItem('userRole');
    return role ? role : null;
}
