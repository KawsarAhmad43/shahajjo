import AddOrBackButton from './../components/elements/AddOrBackButton'
import Search from './../components/Table/Search'
import BaseTable from './../components/Table/BaseTable'
import Pagination from './../components/Table/Pagination'
import IndexPage from './../components/Table/IndexPage'
import ViewPage from './../components/Table/ViewPage'
import ViewBaseTable from './../components/Table/ViewBaseTable'

// input files
import Input from './../components/Form/Input'
import SelectContainer from './../components/Form/SelectContainer'
import Textarea from './../components/Form/Textarea'
import Radio from './../components/Form/Radio'
import Checkbox from './../components/Form/Checkbox'
import File from './../components/Form/File'
import DatePicker from './../components/Form/DatePicker'
import DatePickerOnly from './../components/Form/DatePickerOnly'
import Button from './../components/Form/Button'
import Crop from './../components/Form/Crop'

import GlobalCrop from './../components/elements/GlobalCrop'

import Switch from './../components/Form/Switch'


// page-create
import CreateForm from './../components/Form/CreateForm'

export default (app) => {
    app.component('AddOrBackButton', AddOrBackButton)
    app.component('Search', Search)
    app.component('BaseTable', BaseTable)
    app.component('Pagination', Pagination)
    app.component('IndexPage', IndexPage)
    app.component('ViewPage', ViewPage)
    app.component('ViewBaseTable', ViewBaseTable)
    app.component('Input', Input)
    app.component('v-select-container', SelectContainer)
    app.component('Textarea', Textarea)
    app.component('Radio', Radio)
    app.component('Checkbox', Checkbox)
    app.component('File', File)
    app.component('date-picker', DatePicker)
    app.component('date-picker-only', DatePickerOnly)
    app.component('Button', Button)
    app.component('Crop', Crop)
    app.component('GlobalCrop',GlobalCrop)
    app.component('CreateForm', CreateForm)
     app.component('Switch', Switch)
}
