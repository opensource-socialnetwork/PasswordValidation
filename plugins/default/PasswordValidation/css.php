.jq-password-validator__popover {
    background: #f7d9d9;
    border-radius: 3px;
    box-sizing: border-box;
    color: #111111;
    opacity: 0;
    border: 1px solid #b76363;
    margin-top: 0.5rem;
    padding: 1rem;
    position: absolute;
	top: 0px;
    right: 0;
    text-align: left;
    transition: all 0.5s;
    z-index: 999;
}

.jq-password-validator {
  position: relative; }
  .jq-password-validator.is-hidden .jq-password-validator__popover {
    opacity: 0; }
  .jq-password-validator.is-visible .jq-password-validator__popover {
    opacity: 1; }

.jq-password-validator__checkmark {
  height: 1em;
  fill: #111111;
  margin-right: 0.5em;
  transition: all 0.5s;
  transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
  width: 1em; }

.jq-password-validator__rule {
  overflow: hidden; }
  .jq-password-validator__rule.is-invalid .jq-password-validator__checkmark {
    transform: scale(0);
    visibility: hidden; }
  .jq-password-validator__rule.is-valid .jq-password-validator__checkmark {
    transform: scale(1);
    visibility: visible; }
