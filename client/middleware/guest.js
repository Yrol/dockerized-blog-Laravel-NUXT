/** Middleware to check if user is a guest */
export default function ({store, redirect}) {
  if (store.state.auth.loggedIn) {
    return redirect('/')
  }
}
