{"filter":false,"title":"BillsTable.php","tooltip":"/src/Model/Table/BillsTable.php","undoManager":{"mark":50,"position":50,"stack":[[{"start":{"row":111,"column":41},"end":{"row":112,"column":0},"action":"insert","lines":["",""],"id":2},{"start":{"row":112,"column":0},"end":{"row":112,"column":12},"action":"insert","lines":["            "]}],[{"start":{"row":112,"column":12},"end":{"row":113,"column":0},"action":"insert","lines":["",""],"id":3},{"start":{"row":113,"column":0},"end":{"row":113,"column":12},"action":"insert","lines":["            "]}],[{"start":{"row":113,"column":8},"end":{"row":113,"column":12},"action":"remove","lines":["    "],"id":4}],[{"start":{"row":113,"column":4},"end":{"row":113,"column":8},"action":"remove","lines":["    "],"id":5}],[{"start":{"row":113,"column":0},"end":{"row":113,"column":4},"action":"remove","lines":["    "],"id":6}],[{"start":{"row":113,"column":0},"end":{"row":116,"column":0},"action":"insert","lines":["        $validator","            ->integer('id')","            ->allowEmpty('id', 'create');",""],"id":7}],[{"start":{"row":114,"column":0},"end":{"row":115,"column":0},"action":"remove","lines":["            ->integer('id')",""],"id":8}],[{"start":{"row":114,"column":37},"end":{"row":114,"column":38},"action":"remove","lines":["e"],"id":9}],[{"start":{"row":114,"column":36},"end":{"row":114,"column":37},"action":"remove","lines":["t"],"id":10}],[{"start":{"row":114,"column":35},"end":{"row":114,"column":36},"action":"remove","lines":["a"],"id":11}],[{"start":{"row":114,"column":34},"end":{"row":114,"column":35},"action":"remove","lines":["e"],"id":12}],[{"start":{"row":114,"column":33},"end":{"row":114,"column":34},"action":"remove","lines":["r"],"id":13}],[{"start":{"row":114,"column":32},"end":{"row":114,"column":33},"action":"remove","lines":["c"],"id":14}],[{"start":{"row":114,"column":31},"end":{"row":114,"column":33},"action":"remove","lines":["''"],"id":15}],[{"start":{"row":114,"column":30},"end":{"row":114,"column":31},"action":"remove","lines":[" "],"id":16}],[{"start":{"row":114,"column":29},"end":{"row":114,"column":30},"action":"remove","lines":[","],"id":17}],[{"start":{"row":114,"column":28},"end":{"row":114,"column":29},"action":"remove","lines":["'"],"id":18}],[{"start":{"row":114,"column":27},"end":{"row":114,"column":28},"action":"remove","lines":["d"],"id":19}],[{"start":{"row":114,"column":26},"end":{"row":114,"column":27},"action":"remove","lines":["i"],"id":20}],[{"start":{"row":114,"column":26},"end":{"row":114,"column":27},"action":"insert","lines":["r"],"id":21}],[{"start":{"row":114,"column":27},"end":{"row":114,"column":28},"action":"insert","lines":["i"],"id":22}],[{"start":{"row":114,"column":28},"end":{"row":114,"column":29},"action":"insert","lines":["g"],"id":23}],[{"start":{"row":114,"column":26},"end":{"row":114,"column":29},"action":"remove","lines":["rig"],"id":24},{"start":{"row":114,"column":26},"end":{"row":114,"column":43},"action":"insert","lines":["right_bill_number"]}],[{"start":{"row":114,"column":43},"end":{"row":114,"column":44},"action":"insert","lines":["'"],"id":25}],[{"start":{"row":115,"column":0},"end":{"row":116,"column":0},"action":"insert","lines":["",""],"id":26}],[{"start":{"row":116,"column":0},"end":{"row":118,"column":0},"action":"insert","lines":["        $validator","            ->allowEmpty('right_bill_number');",""],"id":27}],[{"start":{"row":118,"column":0},"end":{"row":119,"column":0},"action":"remove","lines":["",""],"id":28}],[{"start":{"row":117,"column":26},"end":{"row":117,"column":27},"action":"insert","lines":["p"],"id":29}],[{"start":{"row":117,"column":27},"end":{"row":117,"column":28},"action":"insert","lines":["r"],"id":30}],[{"start":{"row":117,"column":28},"end":{"row":117,"column":29},"action":"insert","lines":["e"],"id":31}],[{"start":{"row":117,"column":29},"end":{"row":117,"column":30},"action":"insert","lines":["v"],"id":32}],[{"start":{"row":117,"column":30},"end":{"row":117,"column":31},"action":"insert","lines":["i"],"id":33}],[{"start":{"row":117,"column":31},"end":{"row":117,"column":32},"action":"insert","lines":["o"],"id":34}],[{"start":{"row":117,"column":26},"end":{"row":117,"column":32},"action":"remove","lines":["previo"],"id":35},{"start":{"row":117,"column":26},"end":{"row":117,"column":49},"action":"insert","lines":["previous_control_number"]}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["r"],"id":36}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["i"],"id":37}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["g"],"id":38}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["h"],"id":39}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["t"],"id":40}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["_"],"id":41}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["b"],"id":42}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["i"],"id":43}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["l"],"id":44}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["l"],"id":45}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["_"],"id":46}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["n"],"id":47}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["u"],"id":48}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["m"],"id":49}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["b"],"id":50}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["e"],"id":51}],[{"start":{"row":117,"column":49},"end":{"row":117,"column":50},"action":"remove","lines":["r"],"id":52}]]},"ace":{"folds":[],"scrolltop":1312.5,"scrollleft":0,"selection":{"start":{"row":113,"column":0},"end":{"row":117,"column":52},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":0},"timestamp":1502589692802,"hash":"3d7feef8caf710628b4810745456ecb611923e77"}