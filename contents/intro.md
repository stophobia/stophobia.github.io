<style>

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.badge {
  display: inline-block;
  vertical-align: top;
  font-size: 14px;
  height: 18px;
  line-height: 18px;
  border-radius: 9px;
  padding: 0 5px;
  color: #fff;
  margin-right: 5px;
}
.badge.tip {
  background-color: #42b983;
}
.badge.warning,
.badge.warn {
  background-color: #e7c000;
}


*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.home {
  padding: 3.6rem 2rem 0;
  max-width: 960px;
  margin: 0px auto;
}
.home .hero {
  text-align: center;
}
.home .hero img {
  max-height: 280px;
  display: block;
  margin: 3rem auto 1.5rem;
}
.home .hero h1 {
  font-size: 3rem;
}
.home .hero h1,
.home .hero .description,
.home .hero .action {
  margin: 1.8rem auto;
}
.home .hero .description {
  max-width: 35rem;
  font-size: 1.6rem;
  line-height: 1.3;
  color: #6a8bad;
}
.home .hero .action-button {
  display: inline-block;
  font-size: 1.2rem;
  color: #fff;
  background-color: #603cba;
  padding: 0.8rem 1.6rem;
  border-radius: 4px;
  transition: background-color 0.1s ease;
  box-sizing: border-box;
  border-bottom: 1px solid #5636a7;
}
.home .hero .action-button:hover {
  background-color: #6e4bc5;
}
.home .features {
  border-top: 1px solid #eaecef;
  padding: 1.2rem 0;
  margin-top: 2.5rem;
  display: flex;
  flex-wrap: wrap;
  align-items: flex-start;
  align-content: stretch;
  justify-content: space-between;
}
.home .feature {
  flex-grow: 1;
  flex-basis: 30%;
  max-width: 30%;
}
.home .feature h2 {
  font-size: 1.4rem;
  font-weight: 500;
  border-bottom: none;
  padding-bottom: 0;
  color: #3a5169;
}
.home .feature p {
  color: #4e6e8e;
}
.home .footer {
  padding: 2.5rem;
  border-top: 1px solid #eaecef;
  text-align: center;
  color: #4e6e8e;
}
@media (max-width: 719px) {
.home .features {
    flex-direction: column;
}
.home .feature {
    max-width: 100%;
    padding: 0 2.5rem;
}
}
@media (max-width: 419px) {
.home {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
}
.home .hero img {
    max-height: 210px;
    margin: 2rem auto 1.2rem;
}
.home .hero h1 {
    font-size: 2rem;
}
.home .hero h1,
  .home .hero .description,
  .home .hero .action {
    margin: 1.2rem auto;
}
.home .hero .description {
    font-size: 1.2rem;
}
.home .hero .action-button {
    font-size: 1rem;
    padding: 0.6rem 1.2rem;
}
.home .feature h2 {
    font-size: 1.25rem;
}
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.sidebar-button {
  display: none;
  width: 1.25rem;
  height: 1.25rem;
  position: absolute;
  padding: 0.6rem;
  top: 0.6rem;
  left: 1rem;
}
.sidebar-button .icon {
  display: block;
  width: 1.25rem;
  height: 1.25rem;
}
@media (max-width: 719px) {
.sidebar-button {
    display: block;
}
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.search-box {
  display: inline-block;
  position: relative;
  margin-right: 0.5rem;
}
.search-box input {
  cursor: text;
  width: 10rem;
  color: #4e6e8e;
  display: inline-block;
  border: 1px solid #cfd4db;
  border-radius: 2rem;
  font-size: 0.9rem;
  line-height: 2rem;
  padding: 0 0.5rem 0 2rem;
  outline: none;
  transition: all 0.2s ease;
  background: #fff url(/assets/img/search.83621669.svg) 0.6rem 0.5rem no-repeat;
  background-size: 1rem;
}
.search-box input:focus {
  cursor: auto;
  border-color: #603cba;
}
.search-box .suggestions {
  background: #fff;
  width: 20rem;
  position: absolute;
  top: 1.5rem;
  border: 1px solid #cfd4db;
  border-radius: 6px;
  padding: 0.4rem;
  list-style-type: none;
}
.search-box .suggestions.align-right {
  right: 0;
}
.search-box .suggestion {
  line-height: 1.4;
  padding: 0.4rem 0.6rem;
  border-radius: 4px;
  cursor: pointer;
}
.search-box .suggestion a {
  color: #5d82a6;
}
.search-box .suggestion a .page-title {
  font-weight: 600;
}
.search-box .suggestion a .header {
  font-size: 0.9em;
  margin-left: 0.25em;
}
.search-box .suggestion.focused {
  background-color: #f3f4f5;
}
.search-box .suggestion.focused a {
  color: #603cba;
}
@media (max-width: 959px) {
.search-box input {
    cursor: pointer;
    width: 0;
    border-color: transparent;
    position: relative;
    left: 1rem;
}
.search-box input:focus {
    cursor: text;
    left: 0;
    width: 10rem;
}
}
@media (max-width: 959px) and (min-width: 719px) {
.search-box .suggestions {
    left: 0;
}
}
@media (max-width: 719px) {
.search-box {
    margin-right: 0;
}
.search-box .suggestions {
    right: 0;
}
}
@media (max-width: 419px) {
.search-box .suggestions {
    width: calc(100vw - 4rem);
}
.search-box input:focus {
    width: 8rem;
}
}

.dropdown-enter,
.dropdown-leave-to {
  height: 0 !important;
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.dropdown-wrapper .dropdown-title {
  display: block;
}
.dropdown-wrapper .dropdown-title:hover {
  border-color: transparent;
}
.dropdown-wrapper .dropdown-title .arrow {
  vertical-align: middle;
  margin-top: -1px;
  margin-left: 0.4rem;
}
.dropdown-wrapper .nav-dropdown .dropdown-item {
  color: inherit;
  line-height: 1.7rem;
}
.dropdown-wrapper .nav-dropdown .dropdown-item h4 {
  margin: 0.45rem 0 0;
  border-top: 1px solid #eee;
  padding: 0.45rem 1.5rem 0 1.25rem;
}
.dropdown-wrapper .nav-dropdown .dropdown-item .dropdown-subitem-wrapper {
  padding: 0;
  list-style: none;
}
.dropdown-wrapper .nav-dropdown .dropdown-item .dropdown-subitem-wrapper .dropdown-subitem {
  font-size: 0.9em;
}
.dropdown-wrapper .nav-dropdown .dropdown-item a {
  display: block;
  line-height: 1.7rem;
  position: relative;
  border-bottom: none;
  font-weight: 400;
  margin-bottom: 0;
  padding: 0 1.5rem 0 1.25rem;
}
.dropdown-wrapper .nav-dropdown .dropdown-item a:hover {
  color: #603cba;
}
.dropdown-wrapper .nav-dropdown .dropdown-item a.router-link-active {
  color: #603cba;
}
.dropdown-wrapper .nav-dropdown .dropdown-item a.router-link-active::after {
  content: "";
  width: 0;
  height: 0;
  border-left: 5px solid #603cba;
  border-top: 3px solid transparent;
  border-bottom: 3px solid transparent;
  position: absolute;
  top: calc(50% - 2px);
  left: 9px;
}
.dropdown-wrapper .nav-dropdown .dropdown-item:first-child h4 {
  margin-top: 0;
  padding-top: 0;
  border-top: 0;
}
@media (max-width: 719px) {
.dropdown-wrapper.open .dropdown-title {
    margin-bottom: 0.5rem;
}
.dropdown-wrapper .nav-dropdown {
    transition: height 0.1s ease-out;
    overflow: hidden;
}
.dropdown-wrapper .nav-dropdown .dropdown-item h4 {
    border-top: 0;
    margin-top: 0;
    padding-top: 0;
}
.dropdown-wrapper .nav-dropdown .dropdown-item h4,
  .dropdown-wrapper .nav-dropdown .dropdown-item > a {
    font-size: 15px;
    line-height: 2rem;
}
.dropdown-wrapper .nav-dropdown .dropdown-item .dropdown-subitem {
    font-size: 14px;
    padding-left: 1rem;
}
}
@media (min-width: 719px) {
.dropdown-wrapper {
    height: 1.8rem;
}
.dropdown-wrapper:hover .nav-dropdown {
    display: block !important;
}
.dropdown-wrapper .dropdown-title .arrow {
    border-left: 4px solid transparent;
    border-right: 4px solid transparent;
    border-top: 6px solid #ccc;
    border-bottom: 0;
}
.dropdown-wrapper .nav-dropdown {
    display: none;
    height: auto !important;
    box-sizing: border-box;
    max-height: calc(100vh - 2.7rem);
    overflow-y: auto;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #fff;
    padding: 0.6rem 0;
    border: 1px solid #ddd;
    border-bottom-color: #ccc;
    text-align: left;
    border-radius: 0.25rem;
    white-space: nowrap;
    margin: 0;
}
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.nav-links {
  display: inline-block;
}
.nav-links a {
  line-height: 1.4rem;
  color: inherit;
}
.nav-links a:hover,
.nav-links a.router-link-active {
  color: #603cba;
}
.nav-links .nav-item {
  cursor: pointer;
  position: relative;
  display: inline-block;
  margin-left: 1.5rem;
  line-height: 2rem;
}
.nav-links .repo-link {
  margin-left: 1.5rem;
}
@media (max-width: 719px) {
.nav-links .nav-item,
  .nav-links .repo-link {
    margin-left: 0;
}
}
@media (min-width: 719px) {
.nav-links a:hover,
  .nav-links a.router-link-active {
    color: #2c3e50;
}
.nav-item > a:not(.external):hover,
  .nav-item > a:not(.external).router-link-active {
    margin-bottom: -2px;
    border-bottom: 2px solid #6b47c4;
}
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.navbar {
  padding: 0.7rem 1.5rem;
  line-height: 2.2rem;
  position: relative;
}
.navbar a,
.navbar span,
.navbar img {
  display: inline-block;
}
.navbar .logo {
  height: 2.2rem;
  min-width: 2.2rem;
  margin-right: 0.8rem;
  vertical-align: top;
}
.navbar .site-name {
  font-size: 1.3rem;
  font-weight: 600;
  color: #2c3e50;
  position: relative;
}
.navbar .links {
  font-size: 0.9rem;
  position: absolute;
  right: 1.5rem;
  top: 0.7rem;
}
@media (max-width: 719px) {
.navbar {
    padding-left: 4rem;
}
.navbar .can-hide {
    display: none;
}
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.page-edit,
.page-nav {
  max-width: 740px;
  margin: 0 auto;
  padding: 2rem 2.5rem;
}
@media (max-width: 959px) {
.page-edit,
  .page-nav {
    padding: 2rem;
}
}
@media (max-width: 419px) {
.page-edit,
  .page-nav {
    padding: 1.5rem;
}
}
.page {
  padding-bottom: 2rem;
}
.page-edit {
  padding-top: 1rem;
  padding-bottom: 1rem;
  overflow: auto;
}
.page-edit .edit-link {
  display: inline-block;
}
.page-edit .edit-link a {
  color: #4e6e8e;
  margin-right: 0.25rem;
}
.page-edit .last-updated {
  float: right;
  font-size: 0.9em;
}
.page-edit .last-updated .prefix {
  font-weight: 500;
  color: #4e6e8e;
}
.page-edit .last-updated .time {
  font-weight: 400;
  color: #aaa;
}
.page-nav {
  padding-top: 1rem;
  padding-bottom: 0;
}
.page-nav .inner {
  min-height: 2rem;
  margin-top: 0;
  border-top: 1px solid #eaecef;
  padding-top: 1rem;
  overflow: auto;
}
.page-nav .next {
  float: right;
}
@media (max-width: 719px) {
.page-edit .edit-link {
    margin-bottom: 0.5rem;
}
.page-edit .last-updated {
    font-size: 0.8em;
    float: none;
    text-align: left;
}
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.sidebar .sidebar-sub-headers {
  padding-left: 1rem;
  font-size: 0.95em;
}
a.sidebar-link {
  font-weight: 400;
  display: inline-block;
  color: #2c3e50;
  border-left: 0.25rem solid transparent;
  padding: 0.35rem 1rem 0.35rem 1.25rem;
  line-height: 1.4;
  width: 100%;
  box-sizing: border-box;
}
a.sidebar-link:hover {
  color: #603cba;
}
a.sidebar-link.active {
  font-weight: 600;
  color: #603cba;
  border-left-color: #603cba;
}
.sidebar-group a.sidebar-link {
  padding-left: 2rem;
}
.sidebar-sub-headers a.sidebar-link {
  padding-top: 0.25rem;
  padding-bottom: 0.25rem;
  border-left: none;
}
.sidebar-sub-headers a.sidebar-link.active {
  font-weight: 500;
}

.sidebar-group:not(.first) {
  margin-top: 1em;
}
.sidebar-group .sidebar-group {
  padding-left: 0.5em;
}
.sidebar-group:not(.collapsable) .sidebar-heading {
  cursor: auto;
  color: inherit;
}
.sidebar-heading {
  color: #999;
  transition: color 0.15s ease;
  cursor: pointer;
  font-size: 1.1em;
  font-weight: bold;
  padding: 0 1.5rem;
  margin-top: 0;
  margin-bottom: 0.5rem;
}
.sidebar-heading.open,
.sidebar-heading:hover {
  color: inherit;
}
.sidebar-heading .arrow {
  position: relative;
  top: -0.12em;
  left: 0.5em;
}
.sidebar-heading:.open .arrow {
  top: -0.18em;
}
.sidebar-group-items {
  transition: height 0.1s ease-out;
  overflow: hidden;
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
.sidebar ul {
  padding: 0;
  margin: 0;
  list-style-type: none;
}
.sidebar a {
  display: inline-block;
}
.sidebar .nav-links {
  display: none;
  border-bottom: 1px solid #eaecef;
  padding: 0.5rem 0 0.75rem 0;
}
.sidebar .nav-links a {
  font-weight: 600;
}
.sidebar .nav-links .nav-item,
.sidebar .nav-links .repo-link {
  display: block;
  line-height: 1.25rem;
  font-size: 1.1em;
  padding: 0.5rem 0 0.5rem 1.5rem;
}
.sidebar .sidebar-links {
  padding: 1.5rem 0;
}
@media (max-width: 719px) {
.sidebar .nav-links {
    display: block;
}
.sidebar .nav-links .dropdown-wrapper .nav-dropdown .dropdown-item a.router-link-active::after {
    top: calc(1rem - 2px);
}
.sidebar .sidebar-links {
    padding: 1rem 0;
}
}
/**
 * prism.js tomorrow night eighties for JavaScript, CoffeeScript, CSS and HTML
 * Based on https://github.com/chriskempson/tomorrow-theme
 * @author Rose Pritchard
 */
code[class*="language-"],
pre[class*="language-"] {
	color: #ccc;
	background: none;
	font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
	text-align: left;
	white-space: pre;
	word-spacing: normal;
	word-break: normal;
	word-wrap: normal;
	line-height: 1.5;

	-moz-tab-size: 4;
	-o-tab-size: 4;
	tab-size: 4;

	-webkit-hyphens: none;
	-ms-hyphens: none;
	hyphens: none;
}

/* Code blocks */
pre[class*="language-"] {
	padding: 1em;
	margin: .5em 0;
	overflow: auto;
}
:not(pre) > code[class*="language-"],
pre[class*="language-"] {
	background: #2d2d2d;
}

/* Inline code */
:not(pre) > code[class*="language-"] {
	padding: .1em;
	border-radius: .3em;
	white-space: normal;
}
.token.comment,
.token.block-comment,
.token.prolog,
.token.doctype,
.token.cdata {
	color: #999;
}
.token.punctuation {
	color: #ccc;
}
.token.tag,
.token.attr-name,
.token.namespace,
.token.deleted {
	color: #e2777a;
}
.token.function-name {
	color: #6196cc;
}
.token.boolean,
.token.number,
.token.function {
	color: #f08d49;
}
.token.property,
.token.class-name,
.token.constant,
.token.symbol {
	color: #f8c555;
}
.token.selector,
.token.important,
.token.atrule,
.token.keyword,
.token.builtin {
	color: #cc99cd;
}
.token.string,
.token.char,
.token.attr-value,
.token.regex,
.token.variable {
	color: #7ec699;
}
.token.operator,
.token.entity,
.token.url {
	color: #67cdcc;
}
.token.important,
.token.bold {
	font-weight: bold;
}
.token.italic {
	font-style: italic;
}
.token.entity {
	cursor: help;
}
.token.inserted {
	color: green;
}

*,
body {
  font-family: -apple-system, BlinkMacSystemFont, "Helvetica Neue", "Yu Gothic", "Malgun Gothic", "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
}
img[alt=profile] {
  width: 30%;
}
.text_center {
  width: 100%;
  text-align: center;
}
a.home-link.router-link-active :before {
  content: '';
  display: block;
  float: left;
  margin-top: 6px;
  width: 24px;
  height: 24px;
  background-image: url("//stophobia.github.io/assets/img/profile_stophobia.c0301556.png");
  background-repeat: no-repeat;
  background-position: top left;
  background-size: 24px;
}
a.home-link.router-link-active span.site-name {
  margin-left: 6px;
}
.tab {
  position: relative;
  margin-bottom: 1px;
  width: 100%;
  overflow: hidden;
}
.tab input {
  position: absolute;
  opacity: 0;
  z-index: -1;
}
.tab label {
  position: relative;
  display: block;
  padding: 0;
  font-weight: bold;
  line-height: 3;
  cursor: pointer;
}
.tab input:checked + label > .tab-content {
  max-height: 100vh;
}
.tab label::after {
  position: absolute;
  right: 0;
  top: 0;
  display: block;
  width: 3em;
  height: 3em;
  line-height: 3;
  text-align: center;
  transition: all 0.35s;
}
.tab input[type=checkbox] + label::after,
.tab input[type=radio] + label::after {
  content: "+";
}
.tab input[type=checkbox]:checked + label::after,
.tab input[type=radio]:checked + label::after {
  transform: rotate(315deg);
}
.tab ul li {
  list-style: none;
}
.tab ul li:first-of-type {
  margin-top: 1em;
}
.tab ul li:last-of-type {
  margin-bottom: 1em;
}
.tab-content {
  display: block;
  max-height: 0;
  margin: 0;
  overflow: hidden;
  transition: max-height 0.35s;
  border: 1px solid #eaecef;
}
.tab-content p {
  margin: 1em;
}
#nprogress {
  pointer-events: none;
}
#nprogress .bar {
  background: #603cba;
  position: fixed;
  z-index: 1031;
  top: 0;
  left: 0;
  width: 100%;
  height: 2px;
}
#nprogress .peg {
  display: block;
  position: absolute;
  right: 0px;
  width: 100px;
  height: 100%;
  box-shadow: 0 0 10px #603cba, 0 0 5px #603cba;
  opacity: 1;
  transform: rotate(3deg) translate(0px, -4px);
}
#nprogress .spinner {
  display: block;
  position: fixed;
  z-index: 1031;
  top: 15px;
  right: 15px;
}
#nprogress .spinner-icon {
  width: 18px;
  height: 18px;
  box-sizing: border-box;
  border: solid 2px transparent;
  border-top-color: #603cba;
  border-left-color: #603cba;
  border-radius: 50%;
  animation: nprogress-spinner 400ms linear infinite;
}
.nprogress-custom-parent {
  overflow: hidden;
  position: relative;
}
.nprogress-custom-parent #nprogress .spinner,
.nprogress-custom-parent #nprogress .bar {
  position: absolute;
}
@keyframes nprogress-spinner {
0% {
    transform: rotate(0deg);
}
100% {
    transform: rotate(360deg);
}
}
.content code {
  color: #476582;
  padding: 0.25rem 0.5rem;
  margin: 0;
  font-size: 0.85em;
  background-color: rgba(27,31,35,0.05);
  border-radius: 3px;
}
.content pre,
.content pre[class*="language-"] {
  line-height: 1.4;
  padding: 1.25rem 1.5rem;
  margin: 0.85rem 0;
  background: transparent;
  overflow: auto;
}
.content pre code,
.content pre[class*="language-"] code {
  color: #fff;
  padding: 0;
  background-color: transparent;
  border-radius: 0;
}
div[class*="language-"] {
  position: relative;
  background-color: #282c34;
  border-radius: 6px;
}
div[class*="language-"] .highlight-lines {
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  padding-top: 1.3rem;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  line-height: 1.4;
}
div[class*="language-"] .highlight-lines .highlighted {
  background-color: rgba(0,0,0,0.66);
}
div[class*="language-"] pre {
  position: relative;
  z-index: 1;
}
div[class*="language-"]::before {
  position: absolute;
  z-index: 3;
  top: 0.8em;
  right: 1em;
  font-size: 0.75rem;
  color: rgba(255,255,255,0.4);
}
div[class*="language-"]:not(.line-numbers-mode) .line-numbers-wrapper {
  display: none;
}
div[class*="language-"].line-numbers-mode .highlight-lines .highlighted {
  position: relative;
}
div[class*="language-"].line-numbers-mode .highlight-lines .highlighted:before {
  content: ' ';
  position: absolute;
  z-index: 3;
  left: 0;
  top: 0;
  display: block;
  width: 3.5rem;
  height: 100%;
  background-color: rgba(0,0,0,0.66);
}
div[class*="language-"].line-numbers-mode pre {
  padding-left: 4.5rem;
  vertical-align: middle;
}
div[class*="language-"].line-numbers-mode .line-numbers-wrapper {
  position: absolute;
  top: 0;
  width: 3.5rem;
  text-align: center;
  color: rgba(255,255,255,0.3);
  padding: 1.25rem 0;
  line-height: 1.4;
}
div[class*="language-"].line-numbers-mode .line-numbers-wrapper br {
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}
div[class*="language-"].line-numbers-mode .line-numbers-wrapper .line-number {
  position: relative;
  z-index: 4;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  font-size: 0.85em;
}
div[class*="language-"].line-numbers-mode::after {
  content: '';
  position: absolute;
  z-index: 2;
  top: 0;
  left: 0;
  width: 3.5rem;
  height: 100%;
  border-radius: 6px 0 0 6px;
  border-right: 1px solid rgba(0,0,0,0.66);
  background-color: #282c34;
}
div[class~="language-js"]:before {
  content: 'js';
}
div[class~="language-ts"]:before {
  content: 'ts';
}
div[class~="language-html"]:before {
  content: 'html';
}
div[class~="language-md"]:before {
  content: 'md';
}
div[class~="language-vue"]:before {
  content: 'vue';
}
div[class~="language-css"]:before {
  content: 'css';
}
div[class~="language-sass"]:before {
  content: 'sass';
}
div[class~="language-scss"]:before {
  content: 'scss';
}
div[class~="language-less"]:before {
  content: 'less';
}
div[class~="language-stylus"]:before {
  content: 'stylus';
}
div[class~="language-go"]:before {
  content: 'go';
}
div[class~="language-java"]:before {
  content: 'java';
}
div[class~="language-c"]:before {
  content: 'c';
}
div[class~="language-sh"]:before {
  content: 'sh';
}
div[class~="language-yaml"]:before {
  content: 'yaml';
}
div[class~="language-javascript"]:before {
  content: "js";
}
div[class~="language-typescript"]:before {
  content: "ts";
}
div[class~="language-markup"]:before {
  content: "html";
}
div[class~="language-markdown"]:before {
  content: "md";
}
div[class~="language-json"]:before {
  content: "json";
}
div[class~="language-ruby"]:before {
  content: "rb";
}
div[class~="language-python"]:before {
  content: "py";
}
div[class~="language-bash"]:before {
  content: "sh";
}
.custom-block .custom-block-title {
  font-weight: 600;
  margin-bottom: -0.4rem;
}
.custom-block.tip,
.custom-block.warning,
.custom-block.danger {
  padding: 0.1rem 1.5rem;
  border-left-width: 0.5rem;
  border-left-style: solid;
  margin: 1rem 0;
}
.custom-block.tip {
  background-color: #f3f5f7;
  border-color: #42b983;
}
.custom-block.warning {
  background-color: rgba(255,229,100,0.3);
  border-color: #e7c000;
  color: #6b5900;
}
.custom-block.warning .custom-block-title {
  color: #b29400;
}
.custom-block.warning a {
  color: #2c3e50;
}
.custom-block.danger {
  background-color: #ffe6e6;
  border-color: #c00;
  color: #4d0000;
}
.custom-block.danger .custom-block-title {
  color: #900;
}
.custom-block.danger a {
  color: #2c3e50;
}
.arrow {
  display: inline-block;
  width: 0;
  height: 0;
}
.arrow.up {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-bottom: 6px solid #ccc;
}
.arrow.down {
  border-left: 4px solid transparent;
  border-right: 4px solid transparent;
  border-top: 6px solid #ccc;
}
.arrow.right {
  border-top: 4px solid transparent;
  border-bottom: 4px solid transparent;
  border-left: 6px solid #ccc;
}
.arrow.left {
  border-top: 4px solid transparent;
  border-bottom: 4px solid transparent;
  border-right: 6px solid #ccc;
}
.content:not(.custom) {
  max-width: 740px;
  margin: 0 auto;
  padding: 2rem 2.5rem;
}
@media (max-width: 959px) {
.content:not(.custom) {
    padding: 2rem;
}
}
@media (max-width: 419px) {
.content:not(.custom) {
    padding: 1.5rem;
}
}
.table-of-contents .badge {
  vertical-align: middle;
}
html,
body {
  padding: 0;
  margin: 0;
}
body {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  font-size: 16px;
  color: #2c3e50;
}
.page {
  padding-left: 20rem;
}
.navbar {
  position: fixed;
  z-index: 20;
  top: 0;
  left: 0;
  right: 0;
  height: 3.6rem;
  background-color: #fff;
  box-sizing: border-box;
  border-bottom: 1px solid #eaecef;
}
.sidebar-mask {
  position: fixed;
  z-index: 9;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  display: none;
}
.sidebar {
  font-size: 15px;
  background-color: #fff;
  width: 20rem;
  position: fixed;
  z-index: 10;
  margin: 0;
  top: 3.6rem;
  left: 0;
  bottom: 0;
  box-sizing: border-box;
  border-right: 1px solid #eaecef;
  overflow-y: auto;
}
.content:not(.custom) > *:first-child {
  margin-top: 3.6rem;
}
.content:not(.custom) a:hover {
  text-decoration: underline;
}
.content:not(.custom) p.demo {
  padding: 1rem 1.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
}
.content:not(.custom) img {
  max-width: 100%;
}
.content.custom {
  padding: 0;
  margin: 0;
}
.content.custom img {
  max-width: 100%;
}
a {
  font-weight: 500;
  color: #603cba;
  text-decoration: none;
}
p a code {
  font-weight: 400;
  color: #603cba;
}
kbd {
  background: #eee;
  border: solid 0.15rem #ddd;
  border-bottom: solid 0.25rem #ddd;
  border-radius: 0.15rem;
  padding: 0 0.15em;
}
blockquote {
  font-size: 1.2rem;
  color: #999;
  border-left: 0.25rem solid #dfe2e5;
  margin-left: 0;
  padding-left: 1rem;
}
ul,
ol {
  padding-left: 1.2em;
}
strong {
  font-weight: 600;
}
h1,
h2,
h3,
h4,
h5,
h6 {
  font-weight: 600;
  line-height: 1.25;
}
.content:not(.custom) > h1,
.content:not(.custom) > h2,
.content:not(.custom) > h3,
.content:not(.custom) > h4,
.content:not(.custom) > h5,
.content:not(.custom) > h6 {
  margin-top: -3.1rem;
  padding-top: 4.6rem;
  margin-bottom: 0;
}
.content:not(.custom) > h1:first-child,
.content:not(.custom) > h2:first-child,
.content:not(.custom) > h3:first-child,
.content:not(.custom) > h4:first-child,
.content:not(.custom) > h5:first-child,
.content:not(.custom) > h6:first-child {
  margin-top: -1.5rem;
  margin-bottom: 1rem;
}
.content:not(.custom) > h1:first-child + p,
.content:not(.custom) > h2:first-child + p,
.content:not(.custom) > h3:first-child + p,
.content:not(.custom) > h4:first-child + p,
.content:not(.custom) > h5:first-child + p,
.content:not(.custom) > h6:first-child + p,
.content:not(.custom) > h1:first-child + pre,
.content:not(.custom) > h2:first-child + pre,
.content:not(.custom) > h3:first-child + pre,
.content:not(.custom) > h4:first-child + pre,
.content:not(.custom) > h5:first-child + pre,
.content:not(.custom) > h6:first-child + pre,
.content:not(.custom) > h1:first-child + .custom-block,
.content:not(.custom) > h2:first-child + .custom-block,
.content:not(.custom) > h3:first-child + .custom-block,
.content:not(.custom) > h4:first-child + .custom-block,
.content:not(.custom) > h5:first-child + .custom-block,
.content:not(.custom) > h6:first-child + .custom-block {
  margin-top: 2rem;
}
h1:hover .header-anchor,
h2:hover .header-anchor,
h3:hover .header-anchor,
h4:hover .header-anchor,
h5:hover .header-anchor,
h6:hover .header-anchor {
  opacity: 1;
}
h1 {
  font-size: 2.2rem;
}
h2 {
  font-size: 1.65rem;
  padding-bottom: 0.3rem;
  border-bottom: 1px solid #eaecef;
}
h3 {
  font-size: 1.35rem;
}
a.header-anchor {
  font-size: 0.85em;
  float: left;
  margin-left: -0.87em;
  padding-right: 0.23em;
  margin-top: 0.125em;
  opacity: 0;
}
a.header-anchor:hover {
  text-decoration: none;
}
code,
kbd,
.line-number {
  font-family: source-code-pro, Menlo, Monaco, Consolas, "Courier New", monospace;
}
p,
ul,
ol {
  line-height: 1.7;
}
hr {
  border: 0;
  border-top: 1px solid #eaecef;
}
table {
  border-collapse: collapse;
  margin: 1rem 0;
  display: block;
  overflow-x: auto;
}
tr {
  border-top: 1px solid #dfe2e5;
}
tr:nth-child(2n) {
  background-color: #f6f8fa;
}
th,
td {
  border: 1px solid #dfe2e5;
  padding: 0.6em 1em;
}
.custom-layout {
  padding-top: 3.6rem;
}
.theme-container.sidebar-open .sidebar-mask {
  display: block;
}
.theme-container.no-navbar .content:not(.custom) > h1,
.theme-container.no-navbar h2,
.theme-container.no-navbar h3,
.theme-container.no-navbar h4,
.theme-container.no-navbar h5,
.theme-container.no-navbar h6 {
  margin-top: 1.5rem;
  padding-top: 0;
}
.theme-container.no-navbar .sidebar {
  top: 0;
}
.theme-container.no-navbar .custom-layout {
  padding-top: 0;
}
@media (min-width: 720px) {
.theme-container.no-sidebar .sidebar {
    display: none;
}
.theme-container.no-sidebar .page {
    padding-left: 0;
}
}
@media (max-width: 959px) {
.sidebar {
    font-size: 15px;
    width: 16.4rem;
}
.page {
    padding-left: 16.4rem;
}
}
@media (max-width: 719px) {
.sidebar {
    top: 0;
    padding-top: 3.6rem;
    transform: translateX(-100%);
    transition: transform 0.2s ease;
}
.page {
    padding-left: 0;
}
.theme-container.sidebar-open .sidebar {
    transform: translateX(0);
}
.theme-container.no-navbar .sidebar {
    padding-top: 0;
}
}
@media (max-width: 419px) {
h1 {
    font-size: 1.9rem;
}
.content div[class*="language-"] {
    margin: 0.85rem -1.5rem;
    border-radius: 0;
}
}
</style>

# Good Coding

## 이해하기 쉬운 코드

- 코드는 이해하기 쉬워야 한다.
- 코드는 단시간에 이해할 수 있도록 작성되어야 한다.
- 코드는 짧을수록 좋다.

### 표면상의 개선

#### 명명

- 이름에 정보를 포함시킨다.
- tmp 등 너무 범용적인 이름은 피한다.
- i, j, k 등은 루프의 변수로 사용한다.
- 스코프가 좁은 변수의 이름은 짧은 이름을 사용한다.
- 한계치를 나타내는 경우에은 "min", "max"등을 붙인다.
- 범위를 나타내는 경우에은 "first", "ㅣ ast"등을 붙인다.
- 표괄을 나타내는 경우에는 "begin", "end"등을 붙인다.
- 기능을 나타내는 경우에는 "get", "set"등을 붙인다.

#### 주석

- 주석은 코드를 읽을 시간을 절약하도록 작성한다.
- 주석을 작성하게 된 배경을 설명한다.
- 코드가 이해하기 쉬운 경우는 주석을 생략한다.
- 정수에는 왜 그 값인지 주석을 붙인다.

### 로직의 단순화

#### 제어 흐름을 파악하기 쉽도록 작성한다.

- if 문 작성법

```javascript
// 읽기 어렵다
if (10 < length) {
  //
}

// 읽기 쉽다
if (length > 10) {
  //
}
```

- 3 항연산자
  - 행이 짧아지만 읽기 어렵고 디버그시 단계 파악이 어렵다.
  - if~else 를 사용하는 것을 추천한다.
- 네스트를 얕게 유지한다.
- 함수에서 빨리 탈출한다. 실패 분기, 예외 분기나 완료 분기를 함수의 앞부분에 적용한다.
- 루프 안에는 루프를 적용하지 않는다.

#### 식의 분할

- 설명 변수를 사용하여 분할한다.

```javascript
// 읽기 어렵다
if line.split(':')[0].strip() == "root" {
  //
}

// 읽기 쉽다
username = line.split(':')[0].strip();
if(username == "root"){
  //
}
```

- 요약 변수를 사용하여 분할한다.

```javascript
// 읽기 어렵다
if(request.user.id == document.owner_id){
  // 유저가 사용할 수 있는 변수 / 기능
}
if(request.user.id != document.owner_id){
  // 유저가 사용할 수 없는 변수 / 기능
}

// 읽기 쉽다
final boolean user_owns_document = (request.user.id != document.owner_id)

if(!user_owns_document) {
 // 유저가 사용할 수 있는 변수 / 기능
}
if(user_owns_document) {
 // 유저가 사용할 수 없는 변수 / 기능
}
```

#### 변수

- 생략할 수 있다면 생략한다.

```javascript
// 읽기 어렵다
var remove_one = function(array, value_to_remove) {
  var index_to_remove = null
  for (var i = 0; i < array.length; i += 1) {
    if (array[i] === value_to_remove) {
      index_to_remove = i
      break
    }
  }
  if (index_to_remove !== null) {
    array.splice(index_to_remove, 1)
  }
}

// 읽기 쉽다
var remove_one = function(array, value_to_remove) {
  for (var i = 0; i < array.length; i += 1) {
    if (array[i] === value_to_remove) {
      array.splice(i, 1)
      return
    }
  }
}
```

- 제어 흐름 변수를 생략한다.

```javascript
// 읽기 어렵다
boolean done = false;
while(/* condition */ && !done){
  //
  if(...){
    done = true;
    continue;
  }
}

// 읽기 쉽다
while(/* condition */){
  //
  if(...){
    break;
  }
}
```

- 변수의 스코프를 좁힌다.
- 전역 변수는 될수 있는 한 사용하지 않는다.
- 멤버 변수를 될수 있는 한 사용하지 않는다.

```javascript
// 멤버 변수
class LargeClass {
  string str_;
  void Method1() {
    str_ = ...;
    Method2();
  }
  void Method2() {
    // str_변수를 사용
  }
}

// 지역 변수
class LargeClass {
  void Method1() {
    string str_ = ...;
    Method2(str_);
  }
  void Method2(String str_) {
    // str_변수를 사용
  }
}
```

- class 의 멤버 변수로의 접근 횟수를 줄이기 위해 메소드는 될수 있는 한 static 으로 작성한다.

#### Javascript 의 private 변수

```javascript
// 전역 변수
submitted = false
var submit_form = function(form_name) {
  if (submitted) {
    return // 이중 투고 금지
  }
  submitted = true
}

// closure를 이용한 private변수
var submit_form = (function() {
  var submitted = false
  return function(form_name) {
    if (submitted) {
      return
    }
    submitted = true
  }
})()
```

- 변수는 한번만 작성한다.

```javascript
// 파악하기 어렵다
var setFirstEmptyInput = function(new_value) {
  var found = false
  var i = 1
  var elem = document.getElementById('input' + i)
  while (elem !== null) {
    if (elem.value === '') {
      found = true
      break
    }
    i++
    elem = document.getElementById('input' + i)
  }
  if (found) elem.value = new_value
  return elem
}

// 파악하기 쉽다
var setFirstEmptyInput = function(new_value) {
  for (var i = 1; true; i++) {
    var elem = document.getElementById(' input' + i)
    if (elem === null) {
      return null // Search Failed. No empty input found.
    }
    if (elem.value === '') {
      elem.value = new_value
      return elem
    }
  }
}
```

#### 짧은 코드를 작성한다.

- 범용 함수, 범용 라이브러리를 만들어 재사용한다.
- 평균적인 프로덕트 함수 코드는 10.
