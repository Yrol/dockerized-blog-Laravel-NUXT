/** Middleware to check if the user has already authenticated */
export default function ({store, redirect}) {
  if (store.state.auth.loggedIn) {
    return redirect('/admin')
  }
}
