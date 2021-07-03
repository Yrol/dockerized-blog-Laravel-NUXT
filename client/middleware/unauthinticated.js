/** Middleware to check if the user has not authenticated */
export default function ({store, redirect}) {
  if (!store.state.auth.loggedIn) {
    return redirect('/')
  }
}
