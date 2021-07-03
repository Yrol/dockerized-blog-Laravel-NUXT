import Vue from "vue";
import { ValidationObserver, ValidationProvider } from "vee-validate";
import * as VeeValidate from "vee-validate";

Vue.use(VeeValidate, { inject: false });

Vue.component("ValidationObserver", ValidationObserver);
Vue.component("ValidationProvider", ValidationProvider);

import * as rules from "vee-validate/dist/rules";

Object.keys(rules).forEach(rule => {
  VeeValidate.extend(rule, rules[rule]);
});

VeeValidate.extend("phone", value => {
  var regex = /^\d{6,10}$/;
  if (value.replace(/\s/g, "").match(regex)) {
    return true;
  }
  return false;
});
