<?php

namespace App\Http\Controllers\V1;

use App\Events\EventEmailCriacao;
use App\Http\Controllers\Controller;
use App\Models\FluxoAprovacao;
use App\Models\Itens;
use App\Models\Permissoes;
use App\Models\Solicitacao;
use App\Traits\HttpResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class PermissoesController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->error('Erro na validação', 400, $validator->errors());
        }

        try {
            //dd($validator);
            $created = Permissoes::create($validator->validated());
            //DB::commit();
        } catch (QueryException $e) {
            if (strpos($e->getMessage(), 'unique') !== false) {
                $mensage = Lang::get('validation.custom.database.unique');

                return $this->response('Erro ao Salvar', 400, ['erroSQL' => $mensage]);
            }

            return $this->response('Erro ao Salvar', 400, [$e->getMessage()]);
        }
        if ($created) {
            //dd($request->itens);

            try {

                foreach ($request->itens as $itens) {
                    $dados = [
                        'solicitacao_id' => $created->id,
                        'codProduto' => $itens['codProduto'],
                        'quantidadeProduto' => ($itens['quantidadeProduto'] ?? 0),
                        'naoUsarContrato' => $itens['naoUsarContrato'],
                        'naoUsarEstoque' => $itens['naoUsarEstoque'],
                        'observacoesItem' => ($itens['observacoesItem'] ?? 0),
                        'quantidadeComprar' => ($itens['quantidadeComprar'] ?? 0),
                        'descricao' => ($itens['descricao'] ?? 0),
                        'estoque' => ($itens['estoque'] ?? 0),
                        'saldoMin' => ($itens['saldoMin'] ?? 0),
                        'saldoMax' => ($itens['saldoMax'] ?? 0),
                        'saldoContrato' => ($itens['saldoContrato'] ?? 0),
                        'pedidoAFornecedor' => ($itens['pedidoAFornecedor'] ?? 0),
                        'unidade' => ($itens['unidade'] ?? 0),
                        'precoUntAlvo' => ($itens['precoUntAlvo'] ?? 0),
                        'idObjetoOficina' => ($itens['idObjetoOficina'] ?? 0),
                        'marcado' => ($itens['marcado'] ?? 0),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'idPrd' => $itens['idPrd'],
                        'sequenciaOS' => ($itens['sequenciaOS'] ?? 0),
                        'ItensEtapaAtual' => $request->etapaAtual,
                        'codcfo' => ($itens['codcfo'] ?? 0),
                        'precoUnit' => ($itens['precoUnit'] ?? 0),
                        'tipo' => $itens['tipo'],
                    ];
                    Itens::insert($dados);
                }

                $dados = [
                    'solicitacao_id' => $created->id,
                    'usuario_id' => $request->usuario_id,
                    'informacoesAd' => $request->informacoesAd,
                    'motivoReprovacao' => $request->motivoReprovacao,
                    'motivoCancelamento' => $request->motivoCancelamento,
                    'dataDecisao' => Carbon::now(),
                    'etapa' => $request->etapaAtual,
                    'etapaAnterior' => $request->etapaAnterior,
                    'decisao' => $request->decisao,
                ];
                FluxoAprovacao::insert($dados);

                event(new EventEmailCriacao($created));

            } catch (\Exception $e) {
                // Em caso de erro, faça um rollback
                //DB::rollback();
                //Solicitacao::destroy($created->id);
                return $this->error('Erro ao salvar', 400, [$e->getMessage()]);
            }

            //dd($itens);
            return $this->response('Salvo com sucesso', 200, $created);
        }

        return $this->error('Erro ao salvar', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
